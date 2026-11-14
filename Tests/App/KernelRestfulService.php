<?php

namespace PM\PlentyMarketsBundle\Tests\App;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use PM\PlentyMarketsBundle\Services\RestfulService;
use Psr\Http\Message\RequestInterface;

/**
 * The bundle's RestfulService, as the container builds it, but its Guzzle clients answer from
 * $handler and note their requests in $history. Static, because the container makes the
 * service; KernelTestCase resets both for every test.
 */
final class KernelRestfulService extends RestfulService
{
    public static MockHandler $handler;

    /** @var list<array{request: RequestInterface}> */
    public static array $history = [];

    public static function reset(): void
    {
        self::$handler = new MockHandler();
        self::$history = [];
    }

    protected function createClient(array $config): Client
    {
        $stack = HandlerStack::create(self::$handler);
        $stack->push(Middleware::history(self::$history));

        return new Client(['handler' => $stack] + $config);
    }
}
