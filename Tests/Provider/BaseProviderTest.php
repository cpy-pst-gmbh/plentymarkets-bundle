<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use DateTime;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Helper\ServiceHelper;
use PM\PlentyMarketsBundle\Component\Request\Batch;
use PM\PlentyMarketsBundle\Component\Request\Payload;
use PM\PlentyMarketsBundle\Entity\ApiLock;
use PM\PlentyMarketsBundle\Entity\LimitHistory;
use PM\PlentyMarketsBundle\Services\RestfulService;

use function array_filter;
use function array_values;

/**
 * What every provider inherits: the bookkeeping of the API limits and the locks that spare the
 * other shops of the system, the batch, and the fix for plentymarkets' zero date.
 */
final class BaseProviderTest extends ProviderTestCase
{
    /** What plentymarkets says about the limits with every answer. */
    private static function limits(int $longLeft, int $shortLeft): array
    {
        return [
            'X-Plenty-Global-Long-Period-Limit' => '1000',
            'X-Plenty-Global-Long-Period-Calls-Left' => (string) $longLeft,
            'X-Plenty-Global-Long-Period-Decay' => '1800',
            'X-Plenty-Global-Short-Period-Limit' => '10',
            'X-Plenty-Global-Short-Period-Calls-Left' => (string) $shortLeft,
            'X-Plenty-Global-Short-Period-Decay' => '5',
        ];
    }

    public function testTheLimitsOfEveryAnswerAreRecordedPerPath(): void
    {
        $this->respond(new Response(200, self::limits(900, 8), '{}'));

        $this->service->base($this->config())->getResponse('GET', 'orders/1');

        $histories = $this->persisted(LimitHistory::class);
        self::assertCount(1, $histories);
        $history = $histories[0];
        // As the headers give them: strings, except where a getter declares int.
        self::assertSame(
            ['orders', $this->apiId(), 1000, 900, '900', '10', '8', '8', 0],
            [$history->getPath(), $history->getApi(), $history->getLongPeriodTotal(), $history->getLongPeriodLatest(), $history->getLongPeriodMinimum(), $history->getShortPeriodTotal(), $history->getShortPeriodLatest(), $history->getShortPeriodMinimum(), $history->getShortPeriodException() ?? 0],
        );
        self::assertSame([], $this->persisted(ApiLock::class), 'Enough is left.');
    }

    public function testTooFewCallsLeftInTheHourLockTheApiForItsDecay(): void
    {
        $this->respond(new Response(200, self::limits(300, 8), '{}'));
        $before = new DateTime();

        $this->service->base($this->config())->getResponse('GET', 'orders/1');

        $locks = $this->persisted(ApiLock::class);
        self::assertCount(1, $locks, '30 % left is the share kept for the shops.');
        self::assertSame([ApiLock::TYPE_LIMIT_LOCK_PERCENTAGE, $this->apiId(), 'https://p12345.my.plentysystems.com'], [$locks[0]->getType(), $locks[0]->getApi(), $locks[0]->getDescription()]);
        self::assertEqualsWithDelta($before->getTimestamp() + 1801, $locks[0]->getValidUntil()->getTimestamp(), 2, 'The decay of the long period, and a second.');
    }

    public function testTooFewCallsLeftInTheShortPeriodLockTheApiBriefly(): void
    {
        $this->respond(new Response(200, self::limits(900, 2), '{}'));
        $before = new DateTime();

        $this->service->base($this->config())->getResponse('GET', 'orders/1');

        $locks = $this->persisted(ApiLock::class);
        self::assertCount(1, $locks);
        self::assertSame(ApiLock::TYPE_LIMIT_SHORT_LOCK_PERCENTAGE, $locks[0]->getType());
        self::assertEqualsWithDelta($before->getTimestamp() + 6, $locks[0]->getValidUntil()->getTimestamp(), 2);
    }

    public function testAShortPeriodLimitReachedIsCounted(): void
    {
        $this->respond(new Response(429, self::limits(900, 0), '{"error":"Too many requests"}'));

        $this->service->base($this->config()->setWait(false))->getResponse('GET', 'orders/1');

        $histories = $this->persisted(LimitHistory::class);
        self::assertCount(1, $histories);
        self::assertSame(1, $histories[0]->getShortPeriodException());
        self::assertSame(ApiLock::TYPE_LIMIT_SHORT_LOCK_PERCENTAGE, $this->persisted(ApiLock::class)[0]->getType());
    }

    public function testAPriorityConfigSkipsLocksAndBookkeeping(): void
    {
        $this->service->lockedUntil = new DateTime('+30 minutes');
        $this->respond(new Response(200, self::limits(100, 1), '{"id":1}'));

        $response = $this->service->base($this->config()->setPriority(true))->getResponse('GET', 'orders/1');

        self::assertSame(200, $response->getStatusCode(), 'The lock does not hold it back.');
        self::assertSame([], $this->persisted(LimitHistory::class));
        self::assertSame([], $this->persisted(ApiLock::class));
    }

    public function testALockedApiAnswersWithoutARequest(): void
    {
        $this->service->lockedUntil = new DateTime('+30 minutes');

        $result = $this->service->base($this->config())->getResponse('GET', 'orders/1');

        self::assertInstanceOf(\PM\PlentyMarketsBundle\Component\Exceptions\ApiLockActiveException::class, $result, 'A lock that lasts longer than a minute is not waited for.');
        $this->assertRequestCount(0);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return list<T>
     */
    private function persisted(string $class): array
    {
        return array_values(array_filter($this->service->persisted, static fn (object $object): bool => $object instanceof $class));
    }

    private function apiId(): string
    {
        return ServiceHelper::createApiId(RestfulService::getBaseUri('https://p12345.my.plentysystems.com'), 'rest-user', 'geheim');
    }

    public function testABatchIsSentAsPlentymarketsWantsIt(): void
    {
        $this->respond([]);
        $batch = (new Batch())->addPayload((new Payload())->setResource('items/1')->setMethod('PUT')->setBody(['isActive' => true]));

        $this->service->base($this->config())->getBatchResult($batch);

        $this->assertRequest('POST', '/rest/batch');
        self::assertSame(
            ['limitPerPage' => 50, 'payloads' => [['resource' => 'rest/items/1', 'method' => 'PUT', 'body' => ['isActive' => true]]]],
            $this->body(),
            'As the serializer writes it today; plentymarkets reads "payloads".',
        );
    }

    public function testALargeBatchGoesInPagesOfItsLimit(): void
    {
        $this->respond([], []);
        $batch = new Batch(2);
        foreach ([1, 2, 3] as $id) {
            $batch->addPayload((new Payload())->setResource('items/'.$id)->setMethod('GET'));
        }

        $results = $this->service->base($this->config())->getBatchResult($batch);

        $this->assertRequestCount(2);
        self::assertCount(2, $results);
        self::assertSame(['rest/items/1', 'rest/items/2'], array_column($this->body(0)['payloads'], 'resource'));
        self::assertSame(['rest/items/3'], array_column($this->body(1)['payloads'], 'resource'));
    }

    public function testTheZeroDateOfPlentymarketsIsMadeReadable(): void
    {
        $provider = $this->service->base($this->config());

        $body = $provider->getBodyContentsWithFixedDate(new Response(200, [], '{"a":"-0001-11-30T00:00:00+01:00","b":"-0001-11-30T00:00:00+00:53","c":"2026-03-02T10:14:00+01:00"}'));

        self::assertSame('{"a":"0000-00-00T00:00:00+01:00","b":"0000-00-00T00:00:00+01:00","c":"2026-03-02T10:14:00+01:00"}', $body);
    }
}
