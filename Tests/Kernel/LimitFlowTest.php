<?php

namespace PM\PlentyMarketsBundle\Tests\Kernel;

use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Config;
use PM\PlentyMarketsBundle\Component\Exceptions\ApiLockActiveException;
use PM\PlentyMarketsBundle\Entity\AccessToken;
use PM\PlentyMarketsBundle\Entity\ApiLock;
use PM\PlentyMarketsBundle\Entity\LimitHistory;
use PM\PlentyMarketsBundle\Services\RestfulService;
use PM\PlentyMarketsBundle\Tests\App\KernelRestfulService;

/**
 * The way through the whole bundle with a real database: the token is kept, the limits of each
 * answer are written, and too few calls left lock the API for the next request, so that the
 * shops on the same system keep their share.
 */
final class LimitFlowTest extends BundleKernelTestCase
{
    private const array LOGIN = ['access_token' => 'the-token', 'expires_in' => 86400];

    public function testTheTokenIsKeptInTheDatabaseAndUsedAgain(): void
    {
        KernelRestfulService::$handler->append(self::json(self::LOGIN), new Response(200, [], '{}'), new Response(200, [], '{}'));

        $this->restful()->base(self::config())->getResponse('GET', 'orders/1');
        $this->restful()->base(self::config())->getResponse('GET', 'orders/2');

        self::assertSame(['/rest/login', '/rest/orders/1', '/rest/orders/2'], self::paths(), 'One login for both.');
        $tokens = $this->entityManager()->getRepository(AccessToken::class)->findAll();
        self::assertCount(1, $tokens);
        self::assertSame('the-token', $tokens[0]->getToken());
        self::assertSame('Bearer the-token', KernelRestfulService::$history[2]['request']->getHeaderLine('Authorization'));
    }

    public function testTooFewCallsLeftLockTheNextRequest(): void
    {
        KernelRestfulService::$handler->append(self::json(self::LOGIN), new Response(200, self::limits(250), '{}'));
        $provider = $this->restful()->base(self::config());

        self::assertSame(200, $provider->getResponse('GET', 'orders/1')->getStatusCode());
        // Right away, in the same second: before #65 the lock held only from the next one.
        $second = $provider->getResponse('GET', 'orders/2');

        self::assertInstanceOf(ApiLockActiveException::class, $second, 'The lock lasts the 30 minutes of the decay, which no request waits for.');
        self::assertSame(['/rest/login', '/rest/orders/1'], self::paths(), 'The second request did not leave.');
        self::assertCount(1, $this->entityManager()->getRepository(ApiLock::class)->findAll());
        $history = $this->entityManager()->getRepository(LimitHistory::class)->findOneBy(['path' => 'orders']);
        self::assertSame(250, $history?->getLongPeriodLatest());
    }

    public function testEnoughCallsLeftLockNothing(): void
    {
        KernelRestfulService::$handler->append(self::json(self::LOGIN), new Response(200, self::limits(900), '{}'), new Response(200, self::limits(899), '{}'));
        $provider = $this->restful()->base(self::config());

        $provider->getResponse('GET', 'orders/1');
        $provider->getResponse('GET', 'orders/2');

        self::assertSame([], $this->entityManager()->getRepository(ApiLock::class)->findAll());
        self::assertCount(1, $this->entityManager()->getRepository(LimitHistory::class)->findAll(), 'One row per day and path, written on.');
        self::assertSame(899, $this->entityManager()->getRepository(LimitHistory::class)->findOneBy(['path' => 'orders'])?->getLongPeriodLatest());
    }

    public function testATokenPlentymarketsRefusesIsReplaced(): void
    {
        KernelRestfulService::$handler->append(
            self::json(self::LOGIN),
            new Response(401, [], '{"error":"Unauthenticated."}'),
            self::json(['access_token' => 'new-token', 'expires_in' => 86400]),
            new Response(200, [], '{"id":1}'),
        );

        $response = $this->restful()->base(self::config())->getResponse('GET', 'orders/1');

        // Before #64 login() took the refused token from the database again.
        self::assertSame(200, $response->getStatusCode());
        self::assertSame(['/rest/login', '/rest/orders/1', '/rest/login', '/rest/orders/1'], self::paths());
        self::assertSame('Bearer new-token', KernelRestfulService::$history[3]['request']->getHeaderLine('Authorization'));
        $this->entityManager()->clear();
        self::assertSame(['new-token'], array_map(static fn (AccessToken $token): string => $token->getToken(), $this->entityManager()->getRepository(AccessToken::class)->findAll()), 'The refused token is gone.');
    }

    public function testATokenRefusedAgainAfterANewLoginEndsTheTrying(): void
    {
        KernelRestfulService::$handler->append(
            self::json(self::LOGIN),
            new Response(401, [], '{}'),
            self::json(['access_token' => 'new-token', 'expires_in' => 86400]),
            new Response(401, [], '{}'),
        );

        $response = $this->restful()->base(self::config())->getResponse('GET', 'orders/1');

        self::assertInstanceOf(\GuzzleHttp\Exception\ClientException::class, $response);
        self::assertCount(4, KernelRestfulService::$history, 'One new login, one more try, no loop.');
    }

    private function restful(): RestfulService
    {
        return $this->service(RestfulService::class);
    }

    private static function config(): Config
    {
        return new Config('https://p12345.my.plentysystems.com', 'rest-user', 'geheim', 0.3, 0.2);
    }

    private static function json(array $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode($data, JSON_THROW_ON_ERROR));
    }

    /** @return array<string, string> the limits plentymarkets reports, the short period always fine */
    private static function limits(int $longLeft): array
    {
        return [
            'X-Plenty-Global-Long-Period-Limit' => '1000',
            'X-Plenty-Global-Long-Period-Calls-Left' => (string) $longLeft,
            'X-Plenty-Global-Long-Period-Decay' => '1800',
            'X-Plenty-Global-Short-Period-Limit' => '10',
            'X-Plenty-Global-Short-Period-Calls-Left' => '9',
            'X-Plenty-Global-Short-Period-Decay' => '5',
        ];
    }

    /** @return list<string> */
    private static function paths(): array
    {
        return array_map(static fn (array $entry): string => $entry['request']->getUri()->getPath(), KernelRestfulService::$history);
    }
}
