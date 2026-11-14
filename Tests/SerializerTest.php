<?php

namespace PM\PlentyMarketsBundle\Tests;

use DateTime;
use PHPUnit\Framework\TestCase;
use PM\PlentyMarketsBundle\Component\Model\Order\Order;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderAmount;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderItem;
use PM\PlentyMarketsBundle\Component\Model\Warehouses\LocationStock;
use PM\PlentyMarketsBundle\Component\Response\ItemsResponse;
use PM\PlentyMarketsBundle\Tests\Support\Serializers;

/**
 * What plentymarkets sends is not always what the models declare. JMS took it leniently, and
 * so does the serializer since #58: the golden master tests read ideal answers, these the
 * others.
 */
final class SerializerTest extends TestCase
{
    public function testNumbersAndFlagsAreConvertedToTheDeclaredType(): void
    {
        $order = $this->read('{"id":"2170042","statusId":7,"plentyId":9948.0,"ownerId":"12"}', Order::class);

        self::assertSame(2170042, $order->getId(), 'A string of digits for an int.');
        self::assertSame(7.0, $order->getStatusId(), 'An int for a float.');
        self::assertSame(9948, $order->getPlentyId(), 'A whole float for an int.');
    }

    public function testANullWherePlentymarketsMeansNothingLeavesTheDefault(): void
    {
        $page = $this->read('{"page":1,"isLastPage":true,"entries":null}', ItemsResponse::class);
        $item = $this->read('{"id":null,"orderId":2170042,"amounts":null}', OrderItem::class);

        self::assertSame([], $page->getEntries(), 'Not a TypeError for the array.');
        self::assertSame(2170042, $item->getOrderId());
        self::assertSame([], $item->getAmounts());
    }

    public function testFieldsTheModelDoesNotKnowAreLeftOut(): void
    {
        $order = $this->read('{"id":1,"somethingNew":{"a":1},"_internal":true}', Order::class);

        self::assertSame(1, $order->getId());
    }

    public function testAFieldOfAParentClassIsReadWithItsType(): void
    {
        $amount = $this->read('{"currency":"EUR","exchangeRate":1,"isSystemCurrency":1,"netTotal":"10.5"}', OrderAmount::class);

        self::assertSame(['EUR', 1.0, true, 10.5], [$amount->getCurrency(), $amount->getExchangeRate(), $amount->isIsSystemCurrency(), $amount->getNetTotal()]);
    }

    public function testADateInTheFormatOfItsFieldAndWithoutOne(): void
    {
        $stock = $this->read('{"last_update":"2026-03-02 10:14:00","storage_location":3}', LocationStock::class);
        $order = $this->read('{"createdAt":"2026-03-02T10:14:00+01:00","updatedAt":"-0001-11-30T00:00:00+01:00"}', Order::class);

        self::assertInstanceOf(DateTime::class, $stock->getLastUpdate());
        self::assertSame('2026-03-02 10:14:00 UTC', $stock->getLastUpdate()->format('Y-m-d H:i:s e'));
        self::assertSame(3, $stock->getStorageLocation(), 'Under its serialized name.');
        self::assertSame('2026-03-02T10:14:00+01:00', $order->getCreatedAt()->format(DATE_ATOM));
        self::assertSame('-0001-11-30', $order->getUpdatedAt()->format('Y-m-d'), 'plentymarkets\' zero date.');
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    private function read(string $json, string $class): object
    {
        return Serializers::bundle()->deserialize($json, $class, 'json');
    }
}
