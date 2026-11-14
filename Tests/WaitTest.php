<?php

namespace PM\PlentyMarketsBundle\Tests;

use DateTime;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PM\PlentyMarketsBundle\Component\Config;
use PM\PlentyMarketsBundle\Component\Exceptions\ApiLockActiveException;
use PM\PlentyMarketsBundle\Component\Provider\BaseProvider;
use PM\PlentyMarketsBundle\Tests\Support\MockedRestfulService;

use function microtime;

/**
 * Config::setWait(false): a web request gets a lock, a short period limit, a failed connection
 * or a server error back at once, without sleeping and without a second try (#54). Waiting
 * stays the default, for imports.
 */
final class WaitTest extends TestCase
{
    private MockedRestfulService $service;

    protected function setUp(): void
    {
        $this->service = new MockedRestfulService($this);
        $this->service->handler->append(new Response(200, [], '{"access_token":"the-token","expires_in":86400}'));
    }

    public function testWaitingIsTheDefault(): void
    {
        self::assertTrue(self::config()->isWait());
        self::assertFalse(self::config()->setWait(false)->isWait());
    }

    public function testAShortPeriodLimitIsReturnedAtOnce(): void
    {
        $provider = $this->provider();
        $this->service->handler->append(new Response(429, [], '{"error":"Too many requests"}'));

        $result = $this->timed(fn () => $provider->getResponse('GET', 'orders/1'));

        self::assertInstanceOf(ClientException::class, $result);
        self::assertSame(429, $result->getResponse()->getStatusCode());
        self::assertCount(2, $this->service->history, 'The login and one request, no second try.');
    }

    public function testAFailedConnectionIsReturnedAtOnce(): void
    {
        $provider = $this->provider();
        $this->service->handler->append(new ConnectException('Connection refused', new Request('GET', 'orders/1')));

        self::assertInstanceOf(ConnectException::class, $this->timed(fn () => $provider->getResponse('GET', 'orders/1')));
        self::assertCount(2, $this->service->history);
    }

    public function testAServerErrorIsReturnedAtOnce(): void
    {
        $provider = $this->provider();
        $this->service->handler->append(new Response(502));

        self::assertInstanceOf(ServerException::class, $this->timed(fn () => $provider->getResponse('GET', 'orders/1')));
        self::assertCount(2, $this->service->history);
    }

    public function testALockEndingSoonIsReturnedWithoutARequest(): void
    {
        $provider = $this->provider();
        $this->service->lockedUntil = new DateTime('+30 seconds');

        self::assertInstanceOf(ApiLockActiveException::class, $this->timed(fn () => $provider->getResponse('GET', 'orders/1')));
        self::assertCount(1, $this->service->history, 'Only the login.');
    }

    public function testWaitingTriesAServerErrorOnceMore(): void
    {
        $provider = $this->service->base(self::config());
        $this->service->handler->append(new Response(502), new Response(200, [], '{"id":1}'));

        $response = $provider->getResponse('GET', 'orders/1');

        self::assertSame(200, $response->getStatusCode());
        self::assertCount(3, $this->service->history);
    }

    private function provider(): BaseProvider
    {
        return $this->service->base(self::config()->setWait(false));
    }

    private static function config(): Config
    {
        return new Config('https://p12345.my.plentysystems.com', 'rest-user', 'geheim', 0.3, 0.2);
    }

    /** Runs $call and fails if it slept. */
    private function timed(callable $call): mixed
    {
        $start = microtime(true);
        $result = $call();
        self::assertLessThan(1.0, microtime(true) - $start, 'It waited.');

        return $result;
    }
}
