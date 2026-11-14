<?php

namespace PM\PlentyMarketsBundle\Services;

use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Symfony\Component\Serializer\SerializerInterface;
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
use PM\PlentyMarketsBundle\Component\Provider\ListingsProvider;
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
use SensitiveParameter;
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

    public function listings(Config $config): ListingsProvider
    {
        $this->config = $config;
        $client = $this->login();

        return new ListingsProvider($client, $this);
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

    /**
     * A client with a token: the stored one while it holds, or, with $forceLogin, a new one
     * from plentymarkets in place of the stored one (after a 401, #64).
     */
    public function login(?Config $config = null, bool $forceLogin = false): Client
    {
        if (null === $config) {
            $config = $this->getConfig();
        }

        $uri = self::getBaseUri($config->getUri());

        return $this->createClient(
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
                            $config->getPassword(),
                            $forceLogin
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

    /**
     * The credentials go in the body: in the query they would be part of the URL, which Guzzle
     * puts into every exception message and proxies write into their logs.
     */
    public function getLoginResponse(string $uri, string $username, #[SensitiveParameter] string $password): Throwable|ResponseInterface
    {
        $client = $this->createClient(
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
                    RequestOptions::FORM_PARAMS => [
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


    public function getAccessToken(string $uri, string $username, string $password, bool $forceLogin = false): string
    {
        $api = ServiceHelper::createApiId($uri, $username, $password);
        $token = $this->accessTokenRepository->findOneByApi($api);

        if (null !== $token && true === $forceLogin) {
            /* plentymarkets refused it: it must not be taken again until it runs out */
            $this->objectManager->remove($token);
            $this->objectManager->flush();
            $token = null;
        }

        if (null !== $token) {
            return $token->getToken();
        }

        $response = $this->getLoginResponse($uri, $username, $password);

        if ($response instanceof Exception) {
            throw $response;
        }

        $json = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
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

    /**
     * The Guzzle client of the login and of the providers; a test can give it a handler.
     *
     * @param array<string, mixed> $config
     */
    protected function createClient(array $config): Client
    {
        return new Client($config);
    }

    private function saveObject($object): void
    {
        $this->objectManager->persist($object);
        $this->objectManager->flush();
    }

}
