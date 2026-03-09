<?php

namespace PM\PlentyMarketsBundle\Services;

use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use JMS\Serializer\SerializerInterface;
use PM\PlentyMarketsBundle\Component\Config;
use PM\PlentyMarketsBundle\Component\Helper\ServiceHelper;
use PM\PlentyMarketsBundle\Component\Interfaces\AccessTokenRepositoryInterface;
use PM\PlentyMarketsBundle\Component\Interfaces\ApiLockRepositoryInterface;
use PM\PlentyMarketsBundle\Component\Interfaces\LimitHistoryRepositoryInterface;
use PM\PlentyMarketsBundle\Component\Provider\AccountsProvider;
use PM\PlentyMarketsBundle\Component\Provider\BackendProvider;
use PM\PlentyMarketsBundle\Component\Provider\BaseProvider;
use PM\PlentyMarketsBundle\Component\Provider\CategoryProvider;
use PM\PlentyMarketsBundle\Component\Provider\FulfilmentProvider;
use PM\PlentyMarketsBundle\Component\Provider\ItemsProvider;
use PM\PlentyMarketsBundle\Component\Provider\OrdersProvider;
use PM\PlentyMarketsBundle\Component\Provider\PaymentsProvider;
use PM\PlentyMarketsBundle\Component\Provider\PropertiesProvider;
use PM\PlentyMarketsBundle\Component\Provider\StockManagementProvider;
use PM\PlentyMarketsBundle\Component\Provider\TagsProvider;
use PM\PlentyMarketsBundle\Component\Provider\WarehousesProvider;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use PM\PlentyMarketsBundle\Entity\AccessToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Throwable;


class RestfulService
{
    private Config $config;

    public function __construct(
        private readonly AccessTokenRepositoryInterface $accessTokenRepository,
        private readonly ApiLockRepositoryInterface $apiLockRepository,
        private readonly LimitHistoryRepositoryInterface $limitHistoryRepository,
        private readonly SerializerInterface $serializer,
        private readonly ObjectManager $objectManager,
        private readonly LoggerInterface $logger,
        private readonly bool $parameterGuzzleVerifySsl
    ) {
    }

    public function getObjectManager(): ObjectManager
    {
        return $this->objectManager;
    }

    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getApiLockRepository(): ApiLockRepositoryInterface
    {
        return $this->apiLockRepository;
    }

    public function getLimitHistoryRepository(): LimitHistoryRepositoryInterface
    {
        return $this->limitHistoryRepository;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }


    public function accounts(Config $config): AccountsProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new AccountsProvider($client, $this);
    }

    public function backend(Config $config): BackendProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new BackendProvider($client, $this);
    }

    public function base(Config $config): BaseProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new BaseProvider($client, $this);
    }

    public function categories(Config $config): CategoryProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new CategoryProvider($client, $this);
    }

    public function fulfilment(Config $config): FulfilmentProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new FulfilmentProvider($client, $this);
    }

    public function items(Config $config): ItemsProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new ItemsProvider($client, $this);
    }

    public function orders(Config $config): OrdersProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new OrdersProvider($client, $this);
    }

    public function payments(Config $config): PaymentsProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new PaymentsProvider($client, $this);
    }

    public function properties(Config $config): PropertiesProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new PropertiesProvider($client, $this);
    }

    public function stockManagement(Config $config): StockManagementProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new StockManagementProvider($client, $this);
    }

    public function tags(Config $config): TagsProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new TagsProvider($client, $this);
    }


    public function warehouse(Config $config): WarehousesProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new WarehousesProvider($client, $this);
    }

    public function login(?Config $config = null): Client
    {
        if (null === $config) {
            $config = $this->getConfig();
        }

        $uri = self::getBaseUri($config->getUri());

        return new Client(
            [
                'base_uri' => $uri,
                'verify' => $this->parameterGuzzleVerifySsl,
                'headers' => [
                    'Accept' => 'application/x.plentymarkets.v1+json',
                    'Authorization' => sprintf(
                        'Bearer %s',
                        $this->getAccessToken(
                            $uri,
                            $config->getUsername(),
                            $config->getPassword()
                        )
                    ),
                    BaseProvider::HEADER_INTERNAL_API_ID => ServiceHelper::createApiId(
                        $uri,
                        $config->getUsername(),
                        $config->getPassword()
                    ),
                ],
            ]
        );
    }

    public function getLoginResponse(string $uri, string $username, string $password): Throwable|ResponseInterface
    {
        $client = new Client(
            [
                'base_uri' => $uri,
                'verify' => $this->parameterGuzzleVerifySsl,
            ]
        );

        try {
            $response = $client->request(
                Request::METHOD_POST,
                RestfulUrl::LOGIN,
                [
                    RequestOptions::QUERY => [
                        'username' => $username,
                        'password' => $password,
                    ],
                ]
            );
        } catch (Throwable $e) {
            return $e;
        }

        return $response;
    }


    public function getAccessToken(string $uri, string $username, string $password): string
    {
        $api = ServiceHelper::createApiId($uri, $username, $password);
        $token = $this->accessTokenRepository->findOneByApi($api);

        if ($token instanceof AccessToken) {
            return $token->getToken();
        }

        $response = $this->getLoginResponse($uri, $username, $password);

        if ($response instanceof Exception) {
            throw $response;
        }

        $json = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        $token = $json['access_token'];

        $this->saveAccessToken($api, $token, intval($json['expires_in']));
        $this->increaseStatistics($api, $response->getStatusCode());

        return $token;
    }

    public function saveAccessToken(string $api, string $token, int $expires): Throwable|RestfulService
    {
        try {
            $now = new DateTime();
        } catch (Throwable $e) {
            return $e;
        }

        if ($this->objectManager instanceof EntityManagerInterface) {
            $object = new AccessToken();
        } else {
            $object = new \PM\PlentyMarketsBundle\Document\AccessToken();
        }

        $object
            ->setApi($api)
            ->setCreated($now)
            ->setToken($token)
            ->setValidUntil($now->setTimestamp(time() + $expires - 600));

        $this->saveObject($object);

        return $this;
    }

    public function increaseStatistics(string $internalApiId, int $responseStatusCode, bool $flushEntities = true): Throwable|RestfulService
    {
        return $this;
    }

    public static function getBaseUri(string $uri): string
    {
        if (!str_ends_with($uri, '/')) {
            $uri = sprintf('%s/', $uri);
        }

        if (str_ends_with($uri, 'rest/')) {
            return $uri;
        }

        return sprintf('%srest/', $uri);
    }

    private function saveObject($object): void
    {
        $this->objectManager->persist($object);
        $this->objectManager->flush();
    }

}
