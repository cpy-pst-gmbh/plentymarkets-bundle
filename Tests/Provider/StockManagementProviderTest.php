<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use DateTimeImmutable;
use DateTimeZone;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationStockStorageLocation;
use PM\PlentyMarketsBundle\Component\Model\StockManagement\StockMovement;
use PM\PlentyMarketsBundle\Component\Model\StockManagement\Warehouse;
use PM\PlentyMarketsBundle\Component\Response\ItemLocationsResponse;

/** The warehouses of the stock management, their stock movements and their stock per storage location. */
final class StockManagementProviderTest extends ProviderTestCase
{
    public function testAllWarehousesAreReturnedAsModels(): void
    {
        $second = self::fixture('Model/StockManagement/Warehouse');
        $second['id'] = 2;
        $this->respond([self::fixture('Model/StockManagement/Warehouse'), $second]);

        $warehouses = $this->service->stockManagement($this->config())->getAll();

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/stockmanagement/warehouses', []);
        self::assertContainsOnlyInstancesOf(Warehouse::class, $warehouses);
        self::assertSame([3013, 2], array_map(static fn (Warehouse $warehouse): int => $warehouse->getId(), $warehouses));
        self::assertSame('value-2014', $warehouses[0]->getName());
    }

    public function testAllWarehousesReturnAnError(): void
    {
        $error = ClientException::create(new Request('GET', 'stockmanagement/warehouses'), new Response(403, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->stockManagement($this->config())->getAll());
    }

    public function testAWarehouseIsFetchedByItsId(): void
    {
        $this->respond(self::fixture('Model/StockManagement/Warehouse'));

        $warehouse = $this->service->stockManagement($this->config())->get(3);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/stockmanagement/warehouses/3', []);
        self::assertInstanceOf(Warehouse::class, $warehouse);
        self::assertSame(3013, $warehouse->getId());
        self::assertSame(3016, $warehouse->getTypeId());
        self::assertSame('value-2024', $warehouse->getLogisticsType());
    }

    public function testAMissingWarehouseReturnsTheError(): void
    {
        $error = ClientException::create(new Request('GET', 'stockmanagement/warehouses/3'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->stockManagement($this->config())->get(3));
    }

    public function testTheMovementsOfAWarehouseAreAskedFor1000APage(): void
    {
        $this->respond(self::fixture('Response/StockMovementsResponse'));

        $movements = $this->service->stockManagement($this->config())->getMovements(3);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/stockmanagement/warehouses/3/stock/movements', ['itemsPerPage' => '1000', 'page' => '1']);
        self::assertContainsOnlyInstancesOf(StockMovement::class, $movements);
        self::assertSame([3939, 3957], array_map(static fn (StockMovement $movement): int => $movement->getId(), $movements));
    }

    public function testEveryFieldOfAMovementIsRead(): void
    {
        $this->respond(['isLastPage' => true, 'entries' => [self::fixture('Model/StockManagement/StockMovement')]]);

        $movement = $this->service->stockManagement($this->config())->getMovements(3)[0];

        self::assertSame(2996, $movement->getId());
        self::assertSame(2998, $movement->getItemId());
        self::assertSame(3004, $movement->getVariationId());
        self::assertSame(3005, $movement->getQuantity());
        self::assertSame(3003.25, $movement->getPurchasePrice());
        self::assertSame('value-2006', $movement->getReasonString());
    }

    public function testTheMovementsFromADateAreAskedForWithTheFullIsoDate(): void
    {
        $this->respond(self::fixture('Response/StockMovementsResponse'));

        $this->service->stockManagement($this->config())->getMovements(
            3,
            new DateTimeImmutable('2026-03-02 10:14:05', new DateTimeZone('Europe/Berlin')),
        );

        $this->assertRequest(
            'GET',
            '/rest/stockmanagement/warehouses/3/stock/movements',
            ['createdAtFrom' => '2026-03-02T10:14:05+01:00', 'itemsPerPage' => '1000', 'page' => '1'],
        );
        self::assertStringContainsString('createdAtFrom=2026-03-02T10%3A14%3A05%2B01%3A00', $this->request()->getUri()->getQuery(), 'The plus of the offset is encoded.');
    }

    public function testThePageAndItsSizeCannotBeChangedByTheQuery(): void
    {
        $this->respond(self::fixture('Response/StockMovementsResponse'));

        $this->service->stockManagement($this->config())->getMovements(3, null, 2, ['page' => 9, 'itemsPerPage' => 10, 'variationId' => 5]);

        $this->assertRequest('GET', '/rest/stockmanagement/warehouses/3/stock/movements', ['page' => '2', 'itemsPerPage' => '1000', 'variationId' => '5']);
    }

    public function testTheFollowingPagesOfMovementsAreFetchedAndMergedInOrder(): void
    {
        $this->respond(self::movements(false, [1, 2]), self::movements(false, [3]), self::movements(true, [4]));

        $movements = $this->service->stockManagement($this->config())->getMovements(3, new DateTimeImmutable('2026-03-02T10:14:05+01:00'));

        $this->assertRequestCount(3);
        foreach ([1, 2, 3] as $index => $page) {
            $this->assertRequest(
                'GET',
                '/rest/stockmanagement/warehouses/3/stock/movements',
                ['createdAtFrom' => '2026-03-02T10:14:05+01:00', 'itemsPerPage' => '1000', 'page' => (string) $page],
                $index,
            );
        }
        self::assertSame([1, 2, 3, 4], array_map(static fn (StockMovement $movement): int => $movement->getId(), $movements));
    }

    public function testAnErrorOnALaterPageOfMovementsDropsThePagesBefore(): void
    {
        $error = ClientException::create(new Request('GET', 'stockmanagement/warehouses/3/stock/movements'), new Response(404, [], '{}'));
        $this->respond(self::movements(false, [1, 2]), $error);

        $result = $this->service->stockManagement($this->config())->getMovements(3);

        $this->assertRequestCount(2);
        self::assertSame($error, $result, 'Unlike CategoryProvider::getAll(), the first page is lost.');
    }

    public function testAnErrorOnTheFirstPageOfMovementsIsReturned(): void
    {
        $error = ClientException::create(new Request('GET', 'stockmanagement/warehouses/3/stock/movements'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->stockManagement($this->config())->getMovements(3));
    }

    public function testOnePageOfTheStockPerStorageLocationIsReturnedAsItIs(): void
    {
        $this->respond(self::fixture('Response/ItemLocationsResponse'));

        $page = $this->service->stockManagement($this->config())->getStorageLocationStockPage(3);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/stockmanagement/warehouses/3/stock/storageLocations', ['page' => '1']);
        self::assertInstanceOf(ItemLocationsResponse::class, $page);
        self::assertFalse($page->isIsLastPage());
        self::assertSame(3213, $page->getPage());
        self::assertContainsOnlyInstancesOf(ItemVariationStockStorageLocation::class, $page->getEntries());
        self::assertSame([3222, 3231], array_map(static fn (ItemVariationStockStorageLocation $location): int => $location->getStorageLocationId(), $page->getEntries()));
        self::assertSame('2026-03-16T10:07:00+01:00', $page->getEntries()[0]->getUpdatedAt()->format(DATE_ATOM));
    }

    public function testTheStockPerStorageLocationTakesPageAndQuery(): void
    {
        $this->respond(self::fixture('Response/ItemLocationsResponse'));

        $this->service->stockManagement($this->config())->getStorageLocationStockPage(3, 4, ['itemsPerPage' => 500, 'variationId' => 9]);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/stockmanagement/warehouses/3/stock/storageLocations', ['page' => '4', 'itemsPerPage' => '500', 'variationId' => '9']);
    }

    public function testTheZeroDateInTheStockPerStorageLocationIsReadAsTheYearZero(): void
    {
        $answer = self::fixture('Response/ItemLocationsResponse');
        $answer['entries'][0]['updatedAt'] = '-0001-11-30T00:00:00+01:00';
        $this->respond($answer);

        $page = $this->service->stockManagement($this->config())->getStorageLocationStockPage(3);

        self::assertSame('-0001-11-30T00:00:00+01:00', $page->getEntries()[0]->getUpdatedAt()->format(DATE_ATOM));
    }

    public function testTheStockPerStorageLocationReturnsAnError(): void
    {
        $error = ClientException::create(new Request('GET', 'stockmanagement/warehouses/3/stock/storageLocations'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->stockManagement($this->config())->getStorageLocationStockPage(3));
    }

    /** @param list<int> $ids */
    private static function movements(bool $isLastPage, array $ids): array
    {
        $page = self::fixture('Response/StockMovementsResponse');
        $page['isLastPage'] = $isLastPage;
        $page['entries'] = array_map(static fn (int $id): array => ['id' => $id] + $page['entries'][0], $ids);

        return $page;
    }
}
