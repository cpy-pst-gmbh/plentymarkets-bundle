<?php

namespace PM\PlentyMarketsBundle\Tests\Kernel;

use DateTime;
use PM\PlentyMarketsBundle\Entity\AccessToken;
use PM\PlentyMarketsBundle\Entity\ApiHits;
use PM\PlentyMarketsBundle\Entity\ApiLock;
use PM\PlentyMarketsBundle\Entity\LimitHistory;
use PM\PlentyMarketsBundle\Component\Model\ApiHitsStatisticModel;
use PM\PlentyMarketsBundle\Repository\AccessTokenRepository;
use PM\PlentyMarketsBundle\Repository\ApiHitsRepository;
use PM\PlentyMarketsBundle\Repository\ApiLockRepository;
use PM\PlentyMarketsBundle\Repository\LimitHistoryRepository;

use function array_map;

/** The bundle's repositories against a real database (SQLite), with their own queries. */
final class RepositoryTest extends BundleKernelTestCase
{
    public function testTheLatestTokenIsTakenWhileItHolds(): void
    {
        $this->store(
            self::token('api-1', 'old', '+1 hour'),
            self::token('api-1', 'new', '+20 hours'),
            self::token('api-2', 'other', '+20 hours'),
        );

        self::assertSame('new', $this->service(AccessTokenRepository::class)->findOneByApi('api-1')?->getToken());
        self::assertNull($this->service(AccessTokenRepository::class)->findOneByApi('api-3'));
    }

    public function testATokenThatRanOutIsNone(): void
    {
        $this->store(self::token('api-1', 'expired', '-1 minute'));

        self::assertNull($this->service(AccessTokenRepository::class)->findOneByApi('api-1'));
    }

    public function testOnlyALockInForceCounts(): void
    {
        $this->store(
            self::lock('expired', '-2 hours', '-1 hour'),
            self::lock('deleted', '-1 hour', '+1 hour', deleted: true),
            self::lock('future', '+1 hour', '+2 hours'),
            self::lock('other-api', '-1 hour', '+1 hour', api: 'api-2'),
        );
        $locks = $this->service(ApiLockRepository::class);

        self::assertFalse($locks->hasActive('api-1'));
        self::assertNull($locks->getActive('api-1'));

        $this->store(self::lock('short', '-1 minute', '+5 minutes'), self::lock('long', '-1 minute', '+30 minutes'));

        self::assertTrue($locks->hasActive('api-1'));
        self::assertSame('long', $locks->getActive('api-1')?->getDescription(), 'The one that lasts longest.');
        self::assertSame(['long', 'other-api', 'short'], self::descriptions($locks->findActive()));
    }

    public function testALockWithoutEndHoldsUntilDeleted(): void
    {
        $this->store(self::lock('open', '-1 minute', null));

        self::assertSame('open', $this->service(ApiLockRepository::class)->getActive('api-1')?->getDescription());
    }

    public function testTheLimitHistoryIsThatOfTodayAndThePath(): void
    {
        $this->store(
            self::history('api-1', 'orders', 'yesterday'),
            self::history('api-1', 'items', 'today'),
            self::history('api-1', 'orders', 'today', 700),
        );
        $histories = $this->service(LimitHistoryRepository::class);

        self::assertSame(700, $histories->findCurrent('api-1', 'orders')?->getLongPeriodLatest());
        self::assertNull($histories->findCurrent('api-2', 'orders'));
        self::assertNull($histories->findCurrent('api-1', 'categories'));
    }

    public function testTheApiHitsAreThoseOfTodayAndSummedPerDay(): void
    {
        $this->store(
            self::hits('api-1', 'today', 10, 2),
            self::hits('api-1', '-3 days', 5, 0),
            self::hits('api-1', '-20 days', 99, 99),
            self::hits('api-2', 'today', 7, 7),
        );
        $hits = $this->service(ApiHitsRepository::class);

        self::assertSame(10, $hits->findCurrent('api-1')?->getResponseCode200());

        $statistics = $hits->findByLast14Days('api-1');

        self::assertContainsOnlyInstancesOf(ApiHitsStatisticModel::class, $statistics);
        $counts = [];
        foreach ($statistics as $statistic) {
            $counts[$statistic->getCode()][] = (int) $statistic->getCount();
        }
        self::assertSame([5, 10], $counts['200'], 'Two days in the last fortnight, the older one first.');
        self::assertSame([0, 2], $counts['429']);
    }

    private static function token(string $api, string $token, string $validUntil): AccessToken
    {
        return (new AccessToken())->setApi($api)->setToken($token)->setCreated(new DateTime())->setValidUntil(new DateTime($validUntil));
    }

    private static function lock(string $description, string $from, ?string $until, bool $deleted = false, string $api = 'api-1'): ApiLock
    {
        return (new ApiLock())
            ->setApi($api)
            ->setType(ApiLock::TYPE_LIMIT_LOCK_PERCENTAGE)
            ->setDescription($description)
            ->setValidFrom(new DateTime($from))
            ->setValidUntil(null !== $until ? new DateTime($until) : null)
            ->setDeleted($deleted);
    }

    private static function history(string $api, string $path, string $day, int $longLeft = 900): LimitHistory
    {
        return (new LimitHistory())
            ->setApi($api)->setPath($path)->setDay(new DateTime($day))
            ->setLongPeriodTotal(1000)->setLongPeriodLatest($longLeft)->setLongPeriodMinimum($longLeft)->setLongPeriodException(0)
            ->setShortPeriodTotal(10)->setShortPeriodLatest(8)->setShortPeriodMinimum(8)->setShortPeriodException(0)
            ->setUpdated(new DateTime());
    }

    private static function hits(string $api, string $day, int $ok, int $tooMany): ApiHits
    {
        return (new ApiHits())
            ->setApiId($api)->setDay(new DateTime($day))->setCount($ok + $tooMany)
            ->setResponseCode200($ok)->setResponseCode401(0)->setResponseCode429($tooMany)->setResponseCodeOther(0);
    }

    /** @param list<ApiLock> $locks */
    private static function descriptions(array $locks): array
    {
        $descriptions = array_map(static fn (ApiLock $lock): string => $lock->getDescription(), $locks);
        sort($descriptions);

        return $descriptions;
    }
}
