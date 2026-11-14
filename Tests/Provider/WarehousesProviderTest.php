<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Model\Warehouses\Dimension;
use PM\PlentyMarketsBundle\Component\Model\Warehouses\Level;
use PM\PlentyMarketsBundle\Component\Model\Warehouses\Location;
use PM\PlentyMarketsBundle\Component\Model\Warehouses\LocationStock;
use PM\PlentyMarketsBundle\Component\Response\LocationsResponse;
use PM\PlentyMarketsBundle\Component\Response\LocationStockResponse;

/** The storage locations of a warehouse: their stock, dimensions and levels; the caller pages itself. */
final class WarehousesProviderTest extends ProviderTestCase
{
    public function testThePageOfTheStockOfALocationIsReturnedAsItIs(): void
    {
        $this->respond(self::fixture('Response/LocationStockResponse'));

        $page = $this->service->warehouse($this->config())->getLocationStock(55);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/warehouses/locations/stock/55', ['page' => '1']);
        self::assertInstanceOf(LocationStockResponse::class, $page);
        self::assertFalse($page->isIsLastPage());
        self::assertContainsOnlyInstancesOf(LocationStock::class, $page->getEntries());
        self::assertSame([3662, 3676], array_map(static fn (LocationStock $stock): int => $stock->getId(), $page->getEntries()));
    }

    public function testTheStockOfALocationIsReadWithItsSnakeCaseNames(): void
    {
        $this->respond(['page' => 2, 'isLastPage' => true, 'entries' => [self::fixture('Model/Warehouses/LocationStock')]]);

        $page = $this->service->warehouse($this->config())->getLocationStock(55, 2);

        $this->assertRequest('GET', '/rest/warehouses/locations/stock/55', ['page' => '2']);
        $stock = $page->getEntries()[0];
        self::assertSame(3074, $stock->getId());
        self::assertSame(3075, $stock->getStorageLocation());
        self::assertSame(3081, $stock->getVariationId());
        self::assertSame(3079.25, $stock->getQuantity());
        self::assertSame('2026-03-11 10:42:00', $stock->getLastUpdate()->format('Y-m-d H:i:s'));
    }

    public function testTheStockOfALocationReturnsAnError(): void
    {
        $error = ClientException::create(new Request('GET', 'warehouses/locations/stock/55'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->warehouse($this->config())->getLocationStock(55));
    }

    public function testALocationIsFetchedByItsId(): void
    {
        $this->respond(self::fixture('Model/Warehouses/Location'));

        $location = $this->service->warehouse($this->config())->getLocation(66);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/warehouses/locations/66', []);
        self::assertInstanceOf(Location::class, $location);
        self::assertSame(3053, $location->getId());
        self::assertSame('value-2063', $location->getFullLabel());
        self::assertInstanceOf(Level::class, $location->getWarehouseLocationLevel());
        self::assertSame(3065, $location->getWarehouseLocationLevel()->getId());
    }

    public function testAMissingLocationReturnsTheError(): void
    {
        $error = ClientException::create(new Request('GET', 'warehouses/locations/66'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->warehouse($this->config())->getLocation(66));
    }

    public function testThePageOfTheLocationsOfAWarehouseIsAskedFor100APage(): void
    {
        $this->respond(self::fixture('Response/LocationsResponse'));

        $page = $this->service->warehouse($this->config())->getLocations(3);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/warehouses/3/locations', ['page' => '1', 'itemsPerPage' => '100']);
        self::assertInstanceOf(LocationsResponse::class, $page);
        self::assertFalse($page->isIsLastPage());
        self::assertContainsOnlyInstancesOf(Location::class, $page->getEntries());
        self::assertSame([3698, 3711], array_map(static fn (Location $location): int => $location->getId(), $page->getEntries()));
    }

    public function testTheLocationsOfALevelAreAskedForWithItsId(): void
    {
        $this->respond(self::fixture('Response/LocationsResponse'));

        $this->service->warehouse($this->config())->getLocations(3, 5, 12);

        $this->assertRequest('GET', '/rest/warehouses/3/locations', ['page' => '5', 'itemsPerPage' => '100', 'levelId' => '12']);
    }

    public function testTheLocationsReturnAnError(): void
    {
        $error = ClientException::create(new Request('GET', 'warehouses/3/locations'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->warehouse($this->config())->getLocations(3));
    }

    public function testTheDimensionsOfAWarehouseAreReturnedAsModels(): void
    {
        $second = self::fixture('Model/Warehouses/Dimension');
        $second['id'] = 2;
        $this->respond([self::fixture('Model/Warehouses/Dimension'), $second]);

        $dimensions = $this->service->warehouse($this->config())->getDimensions(3);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/warehouses/3/locations/dimensions', []);
        self::assertContainsOnlyInstancesOf(Dimension::class, $dimensions);
        self::assertSame([3033, 2], array_map(static fn (Dimension $dimension): int => $dimension->getId(), $dimensions));
        self::assertSame('value-2037', $dimensions[0]->getName());
        self::assertSame('2026-03-27T10:02:00+01:00', $dimensions[0]->getCreatedAt()->format(DATE_ATOM));
    }

    public function testTheDimensionsReturnAnError(): void
    {
        $error = ClientException::create(new Request('GET', 'warehouses/3/locations/dimensions'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->warehouse($this->config())->getDimensions(3));
    }

    public function testTheLevelsOfAWarehouseAreReturnedAsModels(): void
    {
        $second = self::fixture('Model/Warehouses/Level');
        $second['id'] = 2;
        $this->respond([self::fixture('Model/Warehouses/Level'), $second]);

        $levels = $this->service->warehouse($this->config())->getLevels(3);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/warehouses/3/locations/levels', []);
        self::assertContainsOnlyInstancesOf(Level::class, $levels);
        self::assertSame([3044, 2], array_map(static fn (Level $level): int => $level->getId(), $levels));
        self::assertSame('value-2048', $levels[0]->getPathName());
    }

    public function testTheLevelsReturnAnError(): void
    {
        $error = ClientException::create(new Request('GET', 'warehouses/3/locations/levels'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->warehouse($this->config())->getLevels(3));
    }
}
