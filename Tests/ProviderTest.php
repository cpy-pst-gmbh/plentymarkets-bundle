<?php

namespace PM\PlentyMarketsBundle\Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PM\PlentyMarketsBundle\Component\Config;
use PM\PlentyMarketsBundle\Component\Model\Item\Item;
use PM\PlentyMarketsBundle\Component\Model\Order\Order;
use PM\PlentyMarketsBundle\Component\Provider\OrdersProvider;
use PM\PlentyMarketsBundle\Component\Request\Batch;
use PM\PlentyMarketsBundle\Component\Request\Payload;
use PM\PlentyMarketsBundle\Tests\Support\MockedRestfulService;
use PM\PlentyMarketsBundle\Tests\Support\Serializers;

use function array_map;
use function json_decode;
use function json_encode;
use function parse_str;

use const DATE_ATOM;
use const JSON_THROW_ON_ERROR;

/**
 * The providers on the way there and back: the request they make, and the models they read
 * from the answer with the bundle's serializer.
 */
final class ProviderTest extends TestCase
{
    private MockedRestfulService $service;

    protected function setUp(): void
    {
        $this->service = new MockedRestfulService($this, Serializers::bundle());
        $this->service->handler->append(new Response(200, [], '{"access_token":"the-token","expires_in":86400}'));
    }

    public function testAnOrderIsAskedForByItsIdAndRead(): void
    {
        $this->service->handler->append(new Response(200, [], json_encode([
            'id' => 2170042,
            'plentyId' => 9948,
            'statusId' => 7.1,
            'statusName' => 'Warenausgang gebucht',
            'createdAt' => '2026-03-02T10:14:00+01:00',
            // What plentymarkets gives for a date that is not set.
            'updatedAt' => '-0001-11-30T00:00:00+01:00',
            'orderItems' => [['id' => 1, 'orderId' => 2170042, 'typeId' => 1, 'quantity' => 3, 'orderItemName' => 'Tomate']],
        ])));

        $order = $this->provider()->getById(2170042, ['with' => ['addresses']]);

        self::assertInstanceOf(Order::class, $order);
        $request = $this->service->history[1]['request'];
        self::assertSame('/rest/orders/2170042', $request->getUri()->getPath());
        parse_str($request->getUri()->getQuery(), $query);
        self::assertSame(['with' => ['addresses']], $query);
        self::assertSame('Bearer the-token', $request->getHeaderLine('Authorization'));

        self::assertSame([2170042, 9948, 7.1, 'Warenausgang gebucht'], [$order->getId(), $order->getPlentyId(), $order->getStatusId(), $order->getStatusName()]);
        self::assertSame('2026-03-02T10:14:00+01:00', $order->getCreatedAt()->format(DATE_ATOM));
        self::assertSame('-0001-11-30', $order->getUpdatedAt()->format('Y-m-d'), 'The zero date is read, not refused.');
        self::assertSame(['Tomate'], array_map(static fn ($item) => $item->getOrderItemName(), $order->getOrderItems()));
    }

    public function testItemsAreReadPageByPage(): void
    {
        $page = static fn (int $number, bool $last, array $ids): Response => new Response(200, [], json_encode([
            'page' => $number,
            'totalsCount' => 3,
            'isLastPage' => $last,
            'entries' => array_map(static fn (int $id): array => ['id' => $id], $ids),
        ]));
        $this->service->handler->append($page(1, false, [1, 2]), $page(2, true, [3]));

        $items = $this->service->items($this->config())->getAll(1, ['itemsPerPage' => 2]);

        self::assertSame([1, 2, 3], array_map(static fn (Item $item): int => $item->getId(), $items));
        parse_str($this->service->history[2]['request']->getUri()->getQuery(), $query);
        self::assertSame(['page' => '2', 'itemsPerPage' => '2'], $query);
    }

    public function testABatchIsSentAsPlentymarketsWantsIt(): void
    {
        $this->service->handler->append(new Response(200, [], '[]'));
        $batch = (new Batch())->addPayload((new Payload())->setResource('items/1')->setMethod('PUT')->setBody(['isActive' => true]));

        $this->service->base($this->config())->getBatchResult($batch);

        $request = $this->service->history[1]['request'];
        self::assertSame(['POST', '/rest/batch'], [$request->getMethod(), $request->getUri()->getPath()]);
        self::assertSame(
            ['limitPerPage' => 50, 'payloads' => [['resource' => 'rest/items/1', 'method' => 'PUT', 'body' => ['isActive' => true]]]],
            json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR),
            'As the serializer writes it today; plentymarkets reads "payloads".',
        );
    }

    private function provider(): OrdersProvider
    {
        return $this->service->orders($this->config());
    }

    private function config(): Config
    {
        return new Config('https://p12345.my.plentysystems.com', 'rest-user', 'geheim', 0.3, 0.2);
    }
}
