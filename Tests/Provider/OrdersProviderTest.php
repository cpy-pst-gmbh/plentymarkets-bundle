<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use DateTimeImmutable;
use DateTimeZone;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\Exception\RuntimeException as SerializerRuntimeException;
use PM\PlentyMarketsBundle\Component\Model\Order\Order;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderDateType;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderItem;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderPropertyType;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderPropertyTypeName;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderReferrer;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderShippingPackage;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderShippingPreset;
use PM\PlentyMarketsBundle\Component\Model\Order\StatusHistoryEntry;
use PM\PlentyMarketsBundle\Component\Provider\OrdersProvider;
use PM\PlentyMarketsBundle\Component\Response\OrderResponse;
use RuntimeException;

use function array_key_exists;
use function array_map;
use function json_encode;

use const DATE_ATOM;
use const JSON_THROW_ON_ERROR;

/** The orders of plentymarkets: reading them, their documents and settings, and writing to them. */
final class OrdersProviderTest extends ProviderTestCase
{
    public function testOrdersUpdatedSinceADateAreAskedForWithTheDateAsIso8601AndItsOffset(): void
    {
        $this->respond(self::fixture('Response/OrderResponse'));
        $since = new DateTimeImmutable('2026-03-02 10:14:00', new DateTimeZone('Europe/Berlin'));

        $result = $this->provider()->findUpdatedAtFrom($since);

        $this->assertRequest('GET', '/rest/orders', [
            'updatedAtFrom' => '2026-03-02T10:14:00+01:00',
            'itemsPerPage' => '250',
            'page' => '1',
            'sortBy' => 'id',
            'sortOrder' => 'asc',
        ]);
        self::assertSame(
            'updatedAtFrom=2026-03-02T10%3A14%3A00%2B01%3A00&itemsPerPage=250&page=1&sortBy=id&sortOrder=asc',
            $this->request()->getUri()->getQuery(),
            'The offset is sent encoded, so that its plus is not read as a space.',
        );
        self::assertInstanceOf(OrderResponse::class, $result);
        self::assertSame([3801, 3802, false], [$result->getPage(), $result->getTotalsCount(), $result->isIsLastPage()]);
        self::assertContainsOnlyInstancesOf(Order::class, $result->getEntries());
        self::assertSame([3851, 3895], array_map(static fn (Order $order) => $order->getId(), $result->getEntries()));
    }

    public function testOrdersUpdatedSinceADateKeepTheZoneOfTheDateGiven(): void
    {
        $this->respond(self::fixture('Response/OrderResponse'));

        $this->provider()->findUpdatedAtFrom(new DateTimeImmutable('2026-07-01 00:30:00', new DateTimeZone('UTC')));

        self::assertSame('2026-07-01T00:30:00+00:00', $this->query()['updatedAtFrom'], 'Not converted to the zone of plentymarkets.');
    }

    public function testOrdersUpdatedSinceADateAreAskedForTheGivenPageWithTheGivenRelations(): void
    {
        $this->respond(self::fixture('Response/OrderResponse'));

        $this->provider()->findUpdatedAtFrom(new DateTimeImmutable('2026-03-02T10:14:00+01:00'), 4, ['addresses', 'orderItems.variation']);

        $this->assertRequestCount(1);
        self::assertSame('4', $this->query()['page']);
        self::assertSame(['addresses', 'orderItems.variation'], $this->query()['with']);
    }

    public function testOrdersUpdatedSinceADateAreReadOnlyOnePageAtATime(): void
    {
        $this->respond(['page' => 1, 'totalsCount' => 3, 'isLastPage' => false, 'entries' => [['id' => 1], ['id' => 2]]]);

        $result = $this->provider()->findUpdatedAtFrom(new DateTimeImmutable('2026-03-02T10:14:00+01:00'));

        $this->assertRequestCount(1);
        self::assertSame([1, 2], array_map(static fn (Order $order) => $order->getId(), $result->getEntries()));
    }

    public function testOrdersUpdatedSinceADateReadTheZeroDateOfPlentymarkets(): void
    {
        $this->respond(json_encode(['page' => 1, 'totalsCount' => 1, 'isLastPage' => true, 'entries' => [['id' => 7, 'updatedAt' => '-0001-11-30T00:00:00+00:53']]], JSON_THROW_ON_ERROR));

        $result = $this->provider()->findUpdatedAtFrom(new DateTimeImmutable('2026-03-02T10:14:00+01:00'));

        self::assertSame('-0001-11-30', $result->getEntries()[0]->getUpdatedAt()->format('Y-m-d'));
    }

    public function testOrdersUpdatedSinceADateGiveTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->findUpdatedAtFrom(new DateTimeImmutable('2026-03-02T10:14:00+01:00')));
    }

    public function testOrdersUpdatedSinceADateThrowWhenTheAnswerCannotBeRead(): void
    {
        $this->respond('{"page":');

        $this->expectException(SerializerRuntimeException::class);

        $this->provider()->findUpdatedAtFrom(new DateTimeImmutable('2026-03-02T10:14:00+01:00'));
    }

    public function testAPageOfOrdersIsAskedForWithTheFiltersGiven(): void
    {
        $this->respond(self::fixture('Response/OrderResponse'));

        $result = $this->provider()->getOrdersPage(3, ['statusFrom' => 5, 'outgoingItemsBookedAtFrom' => '2026-03-01', 'with' => ['addresses']]);

        $this->assertRequest('GET', '/rest/orders', ['page' => '3', 'statusFrom' => '5', 'outgoingItemsBookedAtFrom' => '2026-03-01', 'with' => ['addresses']]);
        self::assertInstanceOf(OrderResponse::class, $result);
        self::assertContainsOnlyInstancesOf(Order::class, $result->getEntries());
        self::assertSame([3851, 3895], array_map(static fn (Order $order) => $order->getId(), $result->getEntries()));
    }

    public function testAPageOfOrdersIsTheFirstWithoutFilters(): void
    {
        $this->respond(['page' => 1, 'totalsCount' => 0, 'isLastPage' => true, 'entries' => []]);

        $result = $this->provider()->getOrdersPage();

        $this->assertRequest('GET', '/rest/orders', ['page' => '1']);
        $this->assertRequestCount(1);
        self::assertSame([], $result->getEntries());
    }

    public function testAPageOfOrdersMayOverrideThePageByItsFilters(): void
    {
        $this->respond(['page' => 9, 'totalsCount' => 0, 'isLastPage' => true, 'entries' => []]);

        $this->provider()->getOrdersPage(2, ['page' => 9]);

        self::assertSame(['page' => '9'], $this->query(), 'The filters are merged over the page.');
    }

    public function testAPageOfOrdersReadsTheZeroDateOfPlentymarkets(): void
    {
        $this->respond(json_encode(['page' => 1, 'totalsCount' => 1, 'isLastPage' => true, 'entries' => [['id' => 7, 'updatedAt' => '-0001-11-30T00:00:00+01:00']]], JSON_THROW_ON_ERROR));

        $result = $this->provider()->getOrdersPage();

        self::assertSame('-0001-11-30', $result->getEntries()[0]->getUpdatedAt()->format('Y-m-d'));
    }

    public function testAPageOfOrdersGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getOrdersPage());
    }

    public function testAPageOfOrdersThrowsWhenTheAnswerCannotBeRead(): void
    {
        $this->respond('not json');

        $this->expectException(SerializerRuntimeException::class);

        $this->provider()->getOrdersPage();
    }

    public function testTheDocumentsArchiveIsGivenAsTheRawBytesOfTheAnswer(): void
    {
        $zip = "PK\x03\x04\x00\xff-0001-11-30T00:00:00+01:00\x00";
        $this->respond(new Response(200, ['Content-Type' => 'application/zip'], $zip));

        $result = $this->provider()->getDocumentsArchive(2170042, 'invoice');

        $this->assertRequest('GET', '/rest/orders/2170042/documents/downloads/invoice', []);
        self::assertSame($zip, $result, 'Not deserialized and the zero date is not touched.');
    }

    public function testTheDocumentsArchiveGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getDocumentsArchive(2170042, 'delivery_note'));
        $this->assertRequest('GET', '/rest/orders/2170042/documents/downloads/delivery_note');
    }

    public function testAnOrderIsFoundByItsExternalOrderId(): void
    {
        $this->respond(['page' => 1, 'totalsCount' => 1, 'isLastPage' => true, 'entries' => [self::fixture('Model/Order/Order')]]);

        $order = $this->provider()->getByExternalOrderId('AMZ-302-1234');

        $this->assertRequest('GET', '/rest/orders', ['externalOrderId' => 'AMZ-302-1234']);
        self::assertInstanceOf(Order::class, $order);
        self::assertSame([2643, 2636], [$order->getId(), $order->getPlentyId()]);
    }

    public function testAnOrderByItsExternalOrderIdIsAskedForWithTheRelationsGiven(): void
    {
        $this->respond(['page' => 1, 'totalsCount' => 1, 'isLastPage' => true, 'entries' => [['id' => 5]]]);

        $this->provider()->getByExternalOrderId('AMZ-302-1234', ['addresses']);

        self::assertSame(['externalOrderId' => 'AMZ-302-1234', 'with' => ['addresses']], $this->query());
    }

    public function testAnOrderByItsExternalOrderIdReadsTheZeroDateOfPlentymarkets(): void
    {
        $this->respond(json_encode(['page' => 1, 'totalsCount' => 1, 'isLastPage' => true, 'entries' => [['id' => 5, 'updatedAt' => '-0001-11-30T00:00:00+01:00']]], JSON_THROW_ON_ERROR));

        $order = $this->provider()->getByExternalOrderId('AMZ-302-1234');

        self::assertSame('-0001-11-30', $order->getUpdatedAt()->format('Y-m-d'));
    }

    public function testNoOrderForAnExternalOrderIdIsAnError(): void
    {
        $this->respond(['page' => 1, 'totalsCount' => 0, 'isLastPage' => true, 'entries' => []]);

        $result = $this->provider()->getByExternalOrderId('AMZ-302-1234');

        self::assertInstanceOf(RuntimeException::class, $result);
        self::assertSame('Found no orders for externalOrderId "AMZ-302-1234"', $result->getMessage());
    }

    public function testSeveralOrdersForAnExternalOrderIdAreAnError(): void
    {
        $this->respond(['page' => 1, 'totalsCount' => 2, 'isLastPage' => true, 'entries' => [['id' => 5], ['id' => 6]]]);

        $result = $this->provider()->getByExternalOrderId('AMZ-302-1234');

        self::assertInstanceOf(RuntimeException::class, $result);
        self::assertSame('Found 2 orders for externalOrderId "AMZ-302-1234"', $result->getMessage());
    }

    public function testAnOrderByItsExternalOrderIdTrustsTheTotalsCountNotTheEntries(): void
    {
        $this->respond(['page' => 1, 'totalsCount' => 1, 'isLastPage' => true, 'entries' => [['id' => 5], ['id' => 6]]]);

        $order = $this->provider()->getByExternalOrderId('AMZ-302-1234');

        self::assertSame(5, $order->getId(), 'The first of the entries.');
    }

    public function testAnOrderByItsExternalOrderIdGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getByExternalOrderId('AMZ-302-1234'));
    }

    public function testAnOrderByItsExternalOrderIdGivesBackTheErrorOfAnUnreadableAnswer(): void
    {
        $this->respond('{"page":');

        self::assertInstanceOf(SerializerRuntimeException::class, $this->provider()->getByExternalOrderId('AMZ-302-1234'));
    }

    /** Taken over from Tests/ProviderTest.php. */
    public function testAnOrderIsAskedForByItsIdAndRead(): void
    {
        $this->respond(json_encode([
            'id' => 2170042,
            'plentyId' => 9948,
            'statusId' => 7.1,
            'statusName' => 'Warenausgang gebucht',
            'createdAt' => '2026-03-02T10:14:00+01:00',
            // What plentymarkets gives for a date that is not set.
            'updatedAt' => '-0001-11-30T00:00:00+01:00',
            'orderItems' => [['id' => 1, 'orderId' => 2170042, 'typeId' => 1, 'quantity' => 3, 'orderItemName' => 'Tomate']],
        ], JSON_THROW_ON_ERROR));

        $order = $this->provider()->getById(2170042, ['with' => ['addresses']]);

        self::assertInstanceOf(Order::class, $order);
        $this->assertRequest('GET', '/rest/orders/2170042', ['with' => ['addresses']]);
        self::assertSame('Bearer the-token', $this->request()->getHeaderLine('Authorization'));

        self::assertSame([2170042, 9948, 7.1, 'Warenausgang gebucht'], [$order->getId(), $order->getPlentyId(), $order->getStatusId(), $order->getStatusName()]);
        self::assertSame('2026-03-02T10:14:00+01:00', $order->getCreatedAt()->format(DATE_ATOM));
        self::assertSame('-0001-11-30', $order->getUpdatedAt()->format('Y-m-d'), 'The zero date is read, not refused.');
        self::assertSame(['Tomate'], array_map(static fn ($item) => $item->getOrderItemName(), $order->getOrderItems()));
    }

    public function testAnOrderByItsIdIsReadFromAFullAnswer(): void
    {
        $this->respond(self::fixture('Model/Order/Order'));

        $order = $this->provider()->getById(2643);

        $this->assertRequest('GET', '/rest/orders/2643', []);
        self::assertSame('', $this->request()->getUri()->getQuery());
        self::assertInstanceOf(Order::class, $order);
        self::assertSame([2643, 2636, 'value-1639'], [$order->getId(), $order->getPlentyId(), $order->getStatusName()]);
        self::assertContainsOnlyInstancesOf(OrderItem::class, $order->getOrderItems());
        self::assertSame([2408, 2435], array_map(static fn (OrderItem $item) => $item->getId(), $order->getOrderItems()));
    }

    public function testAnOrderByItsIdGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getById(2170042));
    }

    public function testAnOrderByItsIdGivesBackTheErrorOfAnUnreadableAnswer(): void
    {
        $this->respond('<html>Wartungsarbeiten</html>');

        self::assertInstanceOf(SerializerRuntimeException::class, $this->provider()->getById(2170042));
    }

    public function testAnOrderWithAddressesIsAskedForWithThem(): void
    {
        $this->respond(['id' => 2170042]);

        $order = $this->provider()->getByIdWithAddresses(2170042);

        $this->assertRequest('GET', '/rest/orders/2170042', ['with' => ['addresses']]);
        self::assertInstanceOf(Order::class, $order);
        self::assertSame(2170042, $order->getId());
    }

    public function testTheShippingPackagesOfAnOrderAreReadAsAList(): void
    {
        $this->respond([self::fixture('Model/Order/OrderShippingPackage'), ['id' => 77] + self::fixture('Model/Order/OrderShippingPackage')]);

        $packages = $this->provider()->getShippingPackages(2170042);

        $this->assertRequest('GET', '/rest/orders/2170042/shipping/packages', []);
        self::assertCount(2, $packages);
        self::assertContainsOnlyInstancesOf(OrderShippingPackage::class, $packages);
        self::assertSame([2857, 77], array_map(static fn (OrderShippingPackage $package) => $package->getId(), $packages));
        self::assertSame('value-1861', $packages[0]->getPackageNumber());
    }

    public function testTheShippingPackagesOfAnOrderGiveTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getShippingPackages(2170042));
    }

    public function testTheStatusHistoryOfAnOrderIsReadAsAList(): void
    {
        $this->respond([self::fixture('Model/Order/StatusHistoryEntry'), ['id' => 78, 'statusId' => 7.1] + self::fixture('Model/Order/StatusHistoryEntry')]);

        $history = $this->provider()->getStatusHistory(2916);

        $this->assertRequest('GET', '/rest/orders/2916/status-history', []);
        self::assertContainsOnlyInstancesOf(StatusHistoryEntry::class, $history);
        self::assertSame([[2915, 2917.25], [78, 7.1]], array_map(static fn (StatusHistoryEntry $entry) => [$entry->getId(), $entry->getStatusId()], $history));
        self::assertSame('2026-03-15T10:58:00+01:00', $history[0]->getCreatedAt()->format(DATE_ATOM));
    }

    public function testTheStatusHistoryOfAnOrderDoesNotFixTheZeroDateAndThrowsOnIt(): void
    {
        $this->respond([['createdAt' => '-0001-11-30T00:00:00+01:00'] + self::fixture('Model/Order/StatusHistoryEntry')]);

        $this->expectException(SerializerRuntimeException::class);
        $this->expectExceptionMessage('Invalid datetime "-0001-11-30T00:00:00+01:00"');

        $this->provider()->getStatusHistory(2916);
    }

    public function testTheStatusHistoryOfAnOrderGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getStatusHistory(2916));
    }

    public function testAnItemOfAnOrderIsFoundByItsId(): void
    {
        $this->respond(self::fixture('Model/Order/Order'));

        $item = $this->provider()->getItemById(2643, 2435);

        $this->assertRequest('GET', '/rest/orders/2643', []);
        self::assertInstanceOf(OrderItem::class, $item);
        self::assertSame(2435, $item->getId());
    }

    public function testAnItemThatIsNotInTheOrderIsNull(): void
    {
        $this->respond(self::fixture('Model/Order/Order'));

        self::assertNull($this->provider()->getItemById(2643, 1));
    }

    public function testAnItemIdGivenAsStringIsNotFound(): void
    {
        $this->respond(self::fixture('Model/Order/Order'));

        self::assertNull($this->provider()->getItemById(2643, '2435'), 'The ids are compared strictly.');
    }

    public function testAnItemOfAnOrderGivesTheErrorOfTheOrderBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getItemById(2643, 2435));
    }

    public function testAPropertyTypeIsReadByItsId(): void
    {
        $this->respond(self::fixture('Model/Order/OrderPropertyType'));

        $type = $this->provider()->getPropertyTypeById(2820);

        $this->assertRequest('GET', '/rest/orders/properties/types/2820', []);
        self::assertInstanceOf(OrderPropertyType::class, $type);
        self::assertSame([2820, 'value-1823'], [$type->getId(), $type->getCast()]);
        self::assertContainsOnlyInstancesOf(OrderPropertyTypeName::class, $type->getNames());
        self::assertSame(['value-1828', 'value-1833'], array_map(static fn (OrderPropertyTypeName $name) => $name->getName(), $type->getNames()));
    }

    public function testAPropertyTypeGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getPropertyTypeById(2820));
    }

    public function testTheShippingPresetsAreReadAsAListWithoutRelations(): void
    {
        $this->respond([self::fixture('Model/Order/OrderShippingPreset')]);

        $presets = $this->provider()->getShippingPresets();

        $this->assertRequest('GET', '/rest/orders/shipping/presets', []);
        self::assertCount(1, $presets);
        self::assertContainsOnlyInstancesOf(OrderShippingPreset::class, $presets);
        self::assertSame([2866, 'value-1868'], [$presets[0]->getId(), $presets[0]->getBackendName()]);
    }

    public function testTheShippingPresetsAreAskedForWithTheRelationGiven(): void
    {
        $this->respond([]);

        $presets = $this->provider()->getShippingPresets('parcelService');

        $this->assertRequest('GET', '/rest/orders/shipping/presets', ['with' => 'parcelService']);
        self::assertSame([], $presets);
    }

    public function testTheShippingPresetsGiveTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getShippingPresets());
    }

    public function testTheReferrersAreReadAsAList(): void
    {
        $this->respond([self::fixture('Model/Order/OrderReferrer'), ['id' => 1, 'name' => 'Mandant (Shop)']]);

        $referrers = $this->provider()->getReferrers();

        $this->assertRequest('GET', '/rest/orders/referrers', []);
        self::assertContainsOnlyInstancesOf(OrderReferrer::class, $referrers);
        self::assertSame([[2846.25, 'value-1850'], [1.0, 'Mandant (Shop)']], array_map(static fn (OrderReferrer $referrer) => [$referrer->getId(), $referrer->getName()], $referrers));
    }

    public function testTheReferrersGiveTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getReferrers());
    }

    public function testTheDateTypesAreReadAsAList(): void
    {
        $this->respond([self::fixture('Model/Order/OrderDateType')]);

        $types = $this->provider()->getDateTypes();

        $this->assertRequest('GET', '/rest/orders/dates/types', []);
        self::assertContainsOnlyInstancesOf(OrderDateType::class, $types);
        self::assertSame([2671, true, 2673], [$types[0]->getId(), $types[0]->isIsErasable(), $types[0]->getPosition()]);
        self::assertCount(2, $types[0]->getNames());
    }

    public function testTheDateTypesGiveTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getDateTypes());
    }

    public function testACommentIsPutOnTheOrderInTheNameOfTheConfiguredUser(): void
    {
        $this->respond(['id' => 1]);

        $result = $this->withPlentyUserId('12', fn () => $this->provider()->postComment(2170042, 'Paket beschädigt'));

        self::assertTrue($result);
        $this->assertRequest('PUT', '/rest/comments', []);
        self::assertSame(
            ['referenceType' => 'order', 'referenceValue' => 2170042, 'text' => 'Paket beschädigt', 'userId' => '12', 'isVisibleForContact' => false],
            $this->body(),
            'The user id is sent as the string it is in the environment.',
        );
    }

    public function testACommentGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->withPlentyUserId('12', fn () => $this->provider()->postComment(2170042, 'Paket beschädigt')));
    }

    public function testAPropertyValueIsPutOnTheOrder(): void
    {
        $this->respond(['orderId' => 2170042, 'typeId' => 7, 'value' => 'DHL']);

        $result = $this->provider()->putProperty(2170042, 7, 'DHL');

        self::assertTrue($result);
        $this->assertRequest('PUT', '/rest/orders/2170042/properties/7', []);
        self::assertSame(['typeId' => 7, 'value' => 'DHL'], $this->body());
    }

    public function testAPropertyValueGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->putProperty(2170042, 7, 'DHL'));
    }

    public function testTheWarehouseOfAnOrderItemIsPutOnTheOrder(): void
    {
        $this->respond(['id' => 2170042]);

        $result = $this->provider()->putItemWarehouse(2170042, 2408, 3);

        self::assertTrue($result);
        $this->assertRequest('PUT', '/rest/orders/2170042', []);
        self::assertSame(['orderItems' => [['id' => 2408, 'warehouseId' => 3]]], $this->body());
    }

    public function testTheWarehouseOfAnOrderItemGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->putItemWarehouse(2170042, 2408, 3));
    }

    private function provider(): OrdersProvider
    {
        return $this->service->orders($this->config());
    }

    /** Runs $call with APP_PLENTY_USER_ID set, as postComment() reads it from $_ENV. */
    private function withPlentyUserId(string $userId, callable $call): mixed
    {
        $had = array_key_exists('APP_PLENTY_USER_ID', $_ENV);
        $before = $_ENV['APP_PLENTY_USER_ID'] ?? null;
        $_ENV['APP_PLENTY_USER_ID'] = $userId;

        try {
            return $call();
        } finally {
            if ($had) {
                $_ENV['APP_PLENTY_USER_ID'] = $before;
            } else {
                unset($_ENV['APP_PLENTY_USER_ID']);
            }
        }
    }

    private static function error(int $status): RequestException
    {
        $error = ClientException::create(new Request('GET', 'https://p12345.my.plentysystems.com/rest/orders'), new Response($status, [], '{"error":{"message":"Not found"}}'));
        self::assertInstanceOf(ClientException::class, $error);

        return $error;
    }
}
