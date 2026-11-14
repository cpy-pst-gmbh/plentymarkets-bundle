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
        KernelRestfulService::$handler->append(self::json(self::LOGIN), new Response(200, self::limits(250), '{}'), new Response(200, [], '{}'));
        $provider = $this->restful()->base(self::config());

        self::assertSame(200, $provider->getResponse('GET', 'orders/1')->getStatusCode());

        $locks = $this->entityManager()->getRepository(ApiLock::class)->findAll();
        self::assertCount(1, $locks);
        $history = $this->entityManager()->getRepository(LimitHistory::class)->findOneBy(['path' => 'orders']);
        self::assertSame(250, $history?->getLongPeriodLatest());

        // A lock is valid from the second it is made, and the repository asks for validFrom < now:
        // a request in the same second still goes out. Recorded as it is.
        self::assertSame(200, $provider->getResponse('GET', 'orders/2')->getStatusCode());

        $this->entityManager()->createQuery('UPDATE '.ApiLock::class.' l SET l.validFrom = :from')->setParameter('from', new \DateTime('-1 second'))->execute();
        $third = $provider->getResponse('GET', 'orders/3');

        self::assertInstanceOf(ApiLockActiveException::class, $third, 'The lock lasts the 30 minutes of the decay, which no request waits for.');
        self::assertSame(['/rest/login', '/rest/orders/1', '/rest/orders/2'], self::paths(), 'The third request did not leave.');
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

    public function testATokenPlentymarketsRefusesIsTriedAgainNotReplaced(): void
    {
        KernelRestfulService::$handler->append(self::json(self::LOGIN), new Response(401, [], '{"error":"Unauthenticated."}'), new Response(401, [], '{"error":"Unauthenticated."}'));

        $response = $this->restful()->base(self::config())->getResponse('GET', 'orders/1');

        // After a 401 the bundle logs in again, but login() takes the token the database still
        // holds as valid: the second try goes out with the same token, and the 401 comes back.
        // Recorded as it is; plentymarkets is unreachable for this user until the token runs out.
        self::assertInstanceOf(\GuzzleHttp\Exception\ClientException::class, $response);
        self::assertSame(['/rest/login', '/rest/orders/1', '/rest/orders/1'], self::paths(), 'No second login.');
        self::assertSame('Bearer the-token', KernelRestfulService::$history[2]['request']->getHeaderLine('Authorization'));
        self::assertCount(1, $this->entityManager()->getRepository(AccessToken::class)->findAll());
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
