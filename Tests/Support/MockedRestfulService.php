<?php

namespace PM\PlentyMarketsBundle\Tests\Support;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Symfony\Component\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;
use PM\PlentyMarketsBundle\Component\Interfaces\AccessTokenRepositoryInterface;
use PM\PlentyMarketsBundle\Component\Interfaces\ApiLockRepositoryInterface;
use PM\PlentyMarketsBundle\Component\Interfaces\LimitHistoryRepositoryInterface;
use PM\PlentyMarketsBundle\Entity\ApiLock;
use PM\PlentyMarketsBundle\Services\RestfulService;
use Psr\Http\Message\RequestInterface;
use Psr\Log\NullLogger;

/**
 * The RestfulService with Guzzle's MockHandler in place of plentymarkets: each client it makes
 * answers from $handler and notes its requests in $history. No token is stored, so the first
 * call of a provider logs in. An API lock is active while $lockedUntil is set. Given one, the
 * serializer is a real one (Serializers::bundle()), for the tests that read models. What the
 * bundle persists (tokens, limit history, locks) is collected in $persisted.
 */
final class MockedRestfulService extends RestfulService
{
    public MockHandler $handler;

    /** @var list<array{request: RequestInterface}> */
    public array $history = [];

    public ?DateTime $lockedUntil = null;

    /** @var list<object> what the bundle handed to the entity manager to keep */
    public array $persisted = [];

    public function __construct(TestCase $test, ?SerializerInterface $serializer = null)
    {
        $service = $this;

        parent::__construct(
            new class implements AccessTokenRepositoryInterface {
                public function findOneByApi(string $api): mixed
                {
                    return null;
                }
            },
            new class($service) implements ApiLockRepositoryInterface {
                public function __construct(private readonly MockedRestfulService $service)
                {
                }

                public function hasActive($api): bool
                {
                    return null !== $this->service->lockedUntil;
                }

                public function getActive($api): ?ApiLock
                {
                    return null !== $this->service->lockedUntil ? (new ApiLock())->setValidUntil($this->service->lockedUntil) : null;
                }
            },
            new class implements LimitHistoryRepositoryInterface {
                public function findCurrent($apiId, $path): mixed
                {
                    return null;
                }
            },
            $serializer ?? (fn (): SerializerInterface => $this->createStub(SerializerInterface::class))->call($test),
            (function () use ($service): EntityManagerInterface {
                $entityManager = $this->createStub(EntityManagerInterface::class);
                $entityManager->method('persist')->willReturnCallback(static function (object $object) use ($service): void {
                    $service->persisted[] = $object;
                });

                return $entityManager;
            })->call($test),
            new NullLogger(),
            true
        );

        $this->handler = new MockHandler();
    }

    protected function createClient(array $config): Client
    {
        $stack = HandlerStack::create($this->handler);
        $stack->push(Middleware::history($this->history));

        return new Client(['handler' => $stack] + $config);
    }
}
