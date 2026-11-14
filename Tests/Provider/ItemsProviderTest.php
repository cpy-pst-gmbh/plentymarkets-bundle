<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use Closure;
use DateTimeImmutable;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PM\PlentyMarketsBundle\Component\Model\Item\Barcode;
use PM\PlentyMarketsBundle\Component\Model\Item\Item;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemImage;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemShippingProfile;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariation;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationBarcode;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationDescription;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationSalesPrice;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationStock;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationStockStorageLocation;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationSupplier;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationWarehouse;
use PM\PlentyMarketsBundle\Component\Model\Item\Manufacturer;
use PM\PlentyMarketsBundle\Component\Model\Item\SalesPrice;
use PM\PlentyMarketsBundle\Component\Model\Item\Unit;
use PM\PlentyMarketsBundle\Component\Provider\ItemsProvider;
use PM\PlentyMarketsBundle\Component\Response\ItemsVariationsResponse;
use RuntimeException;
use Throwable;
use TypeError;

use function array_map;
use function time;

use const DATE_ATOM;

/** The items of plentymarkets: what each method asks for, and what it makes of the answer. */
final class ItemsProviderTest extends ProviderTestCase
{
    /** What plentymarkets gives for a date that is not set, in the two forms the bundle fixes. */
    private const ZERO_DATE = '-0001-11-30T00:00:00+01:00';
    private const ZERO_DATE_LMT = '-0001-11-30T00:00:00+00:53';

    /** 2020-01-01 00:00 in the default zone of the tests (UTC, phpunit.xml). */
    private const DEFAULT_SINCE = '1577836800';

    // getAll()

    public function testItemsAreReadPageByPage(): void
    {
        $this->respond(self::page([['id' => 1], ['id' => 2]], false, 1), self::page([['id' => 3]], true, 2));

        $items = $this->items()->getAll(1, ['itemsPerPage' => 2]);

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/items', ['page' => '1', 'itemsPerPage' => '2'], 0);
        $this->assertRequest('GET', '/rest/items', ['page' => '2', 'itemsPerPage' => '2'], 1);
        self::assertContainsOnlyInstancesOf(Item::class, $items);
        self::assertSame([1, 2, 3], self::ids($items));
    }

    public function testAnItemIsReadWithAllItsFields(): void
    {
        $this->respond(self::page([self::fixture('Model/Item/Item')], true));

        $items = $this->items()->getAll();

        $this->assertRequest('GET', '/rest/items', ['page' => '1']);
        self::assertCount(1, $items);
        self::assertInstanceOf(Item::class, $items[0]);
        self::assertSame([1160, 1168, 'value-162'], [$items[0]->getId(), $items[0]->getMainVariationId(), $items[0]->getItemType()]);
        self::assertCount(2, $items[0]->getVariations());
        self::assertContainsOnlyInstancesOf(ItemVariation::class, $items[0]->getVariations());
    }

    public function testAFailingLaterItemPageIsLeftOut(): void
    {
        $this->respond(self::page([['id' => 1]], false), self::notFound());

        $items = $this->items()->getAll();

        $this->assertRequestCount(2);
        self::assertSame([1], self::ids($items), 'The error is only logged.');
    }

    public function testAnItemPageWithoutEntriesIsATypeError(): void
    {
        $this->respond(['page' => 1, 'isLastPage' => true]);

        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('must be of type Throwable|array, null returned');

        $this->items()->getAll();
    }

    public function testTheZeroDateOfAnItemIsNotFixedAndRefused(): void
    {
        $this->respond(self::page([['id' => 1, 'updatedAt' => self::ZERO_DATE]], true));

        $this->expectException(RuntimeException::class);

        $this->items()->getAll();
    }

    // getVariationsPage()

    public function testAVariationPageIsReadAloneWithItsQuery(): void
    {
        $this->respond(self::fixture('Response/ItemsVariationsResponse'));

        $page = $this->items()->getVariationsPage(3, ['itemsPerPage' => 50, 'with' => 'stock']);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/items/variations', ['page' => '3', 'itemsPerPage' => '50', 'with' => 'stock']);
        self::assertInstanceOf(ItemsVariationsResponse::class, $page);
        self::assertSame([3395, false], [$page->getPage(), $page->isIsLastPage()], 'It does not follow the next page.');
        self::assertContainsOnlyInstancesOf(ItemVariation::class, $page->getEntries());
        self::assertSame([3404], [$page->getEntries()[0]->getId()]);
    }

    public function testTheZeroDateOfAVariationPageIsMadeReadable(): void
    {
        $this->respond(self::page([['id' => 1, 'updatedAt' => self::ZERO_DATE_LMT, 'createdAt' => self::ZERO_DATE]], true));

        $page = $this->items()->getVariationsPage();

        $variation = $page->getEntries()[0];
        self::assertSame(self::ZERO_DATE, $variation->getUpdatedAt()->format(DATE_ATOM));
        self::assertSame(self::ZERO_DATE, $variation->getCreatedAt()->format(DATE_ATOM));
    }

    // getAllVariations()

    public function testVariationsAreReadPageByPage(): void
    {
        $this->respond(self::page([['id' => 11], ['id' => 12]], false), self::page([['id' => 13, 'updatedAt' => self::ZERO_DATE_LMT]], true, 2));

        $variations = $this->items()->getAllVariations(1, ['with' => 'stock']);

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/items/variations', ['page' => '1', 'with' => 'stock'], 0);
        $this->assertRequest('GET', '/rest/items/variations', ['page' => '2', 'with' => 'stock'], 1);
        self::assertContainsOnlyInstancesOf(ItemVariation::class, $variations);
        self::assertSame([11, 12, 13], self::ids($variations));
        self::assertSame(self::ZERO_DATE, $variations[2]->getUpdatedAt()->format(DATE_ATOM), 'The zero date is fixed.');
    }

    public function testAFailingLaterVariationPageIsLeftOut(): void
    {
        $this->respond(self::page([['id' => 11]], false), self::notFound());

        $variations = $this->items()->getAllVariations();

        $this->assertRequestCount(2);
        self::assertSame([11], self::ids($variations));
    }

    // getAllWithVariations(), getAllWithVariationsAndImages()

    /** @return iterable<string, array{string, string}> */
    public static function allWith(): iterable
    {
        yield 'getAllWithVariations' => ['getAllWithVariations', 'variations'];
        yield 'getAllWithVariationsAndImages' => ['getAllWithVariationsAndImages', 'variations,itemImages'];
    }

    #[DataProvider('allWith')]
    public function testAllItemsAreReadWithTheirRelationsInReverseOrder(string $method, string $with): void
    {
        $this->respond(self::page([['id' => 1], ['id' => 2]], false), self::page([['id' => 3]], true, 2));

        $items = $this->items()->{$method}();

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/items', ['page' => '1', 'with' => $with], 0);
        $this->assertRequest('GET', '/rest/items', ['page' => '2', 'with' => $with], 1);
        self::assertContainsOnlyInstancesOf(Item::class, $items);
        self::assertSame([3, 2, 1], self::ids($items));
    }

    #[DataProvider('allWith')]
    public function testAllItemsWithRelationsFailWithATypeErrorInsteadOfTheError(string $method, string $with): void
    {
        $this->respond(self::notFound());

        try {
            $this->items()->{$method}();
            self::fail('There was no TypeError.');
        } catch (TypeError $error) {
            self::assertStringContainsString('array_reverse()', $error->getMessage(), 'The error answer is handed to array_reverse().');
        }
        $this->assertRequest('GET', '/rest/items', ['page' => '1', 'with' => $with]);
    }

    // getBarcodes()

    public function testBarcodesAreReadPageByPage(): void
    {
        $this->respond(self::page([self::fixture('Model/Item/Barcode')], false), self::page([['id' => 7, 'name' => 'EAN']], true, 2));

        $barcodes = $this->items()->getBarcodes();

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/items/barcodes', ['page' => '1'], 0);
        $this->assertRequest('GET', '/rest/items/barcodes', ['page' => '2'], 1);
        self::assertContainsOnlyInstancesOf(Barcode::class, $barcodes);
        self::assertSame([1156, 7], self::ids($barcodes));
        self::assertSame(['value-157', 'EAN'], array_map(static fn (Barcode $barcode): string => $barcode->getName(), $barcodes));
    }

    public function testAFailingLaterBarcodePageIsATypeError(): void
    {
        $this->respond(self::page([['id' => 7]], false), self::notFound());

        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('array_merge()');

        $this->items()->getBarcodes();
    }

    // getById()

    public function testAnItemIsReadByItsIdWithItsQuery(): void
    {
        $this->respond(self::fixture('Model/Item/Item'));

        $item = $this->items()->getById(1160, ['with' => ['variations', 'itemImages']]);

        $this->assertRequest('GET', '/rest/items/1160', ['with' => ['variations', 'itemImages']]);
        self::assertInstanceOf(Item::class, $item);
        self::assertSame([1160, 1168], [$item->getId(), $item->getMainVariationId()]);
        self::assertSame('2026-03-08T10:55:00+01:00', $item->getUpdatedAt()->format(DATE_ATOM));
        self::assertContainsOnlyInstancesOf(ItemImage::class, $item->getItemImages());
    }

    // getManufacturers()

    public function testManufacturersAreReadPageByPage(): void
    {
        $this->respond(self::page([self::fixture('Model/Item/Manufacturer')], false), self::page([['id' => 8, 'name' => 'Sperli']], true, 2));

        $manufacturers = $this->items()->getManufacturers();

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/items/manufacturers', ['page' => '1'], 0);
        $this->assertRequest('GET', '/rest/items/manufacturers', ['page' => '2'], 1);
        self::assertContainsOnlyInstancesOf(Manufacturer::class, $manufacturers);
        self::assertSame([2227, 8], self::ids($manufacturers));
        self::assertSame(['value-1228', 'Sperli'], array_map(static fn (Manufacturer $manufacturer): string => $manufacturer->getName(), $manufacturers));
    }

    public function testAFailingLaterManufacturerPageIsATypeError(): void
    {
        $this->respond(self::page([['id' => 8]], false), self::notFound());

        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('array_merge()');

        $this->items()->getManufacturers();
    }

    // getSalesPrice()

    public function testASalesPriceIsReadByItsId(): void
    {
        $this->respond(self::fixture('Model/Item/SalesPrice'));

        $price = $this->items()->getSalesPrice(2263);

        $this->assertRequest('GET', '/rest/items/sales_prices/2263', []);
        self::assertInstanceOf(SalesPrice::class, $price);
        self::assertSame([2263, 'value-1266', 2265.25], [$price->getId(), $price->getType(), $price->getMinimumOrderQuantity()]);
    }

    // getShippingProfiles()

    public function testTheShippingProfilesOfAnItemAreRead(): void
    {
        $this->respond([self::fixture('Model/Item/ItemShippingProfile'), ['id' => 2, 'itemId' => 5, 'profileId' => 6]]);

        $profiles = $this->items()->getShippingProfiles(5);

        $this->assertRequest('GET', '/rest/items/5/item_shipping_profiles', []);
        self::assertContainsOnlyInstancesOf(ItemShippingProfile::class, $profiles);
        self::assertSame([1584, 2], self::ids($profiles));
        self::assertSame([1586, 6], array_map(static fn (ItemShippingProfile $profile): int => $profile->getProfileId(), $profiles));
    }

    // getUpdatedSince()

    public function testItemsUpdatedSinceADateAreAskedForWithItsTimestamp(): void
    {
        $this->respond(self::page([['id' => 1]], false), self::page([['id' => 2]], true, 2));

        $items = $this->items()->getUpdatedSince(new DateTimeImmutable('2026-03-02T10:14:00+01:00'));

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/items', ['page' => '1', 'with' => 'itemImages', 'updatedBetween' => '1772442840'], 0);
        $this->assertRequest('GET', '/rest/items', ['page' => '2', 'with' => 'itemImages', 'updatedBetween' => '1772442840'], 1);
        self::assertSame([1, 2], self::ids($items));
    }

    public function testItemsUpdatedSinceNoDateAreAskedForSince2020(): void
    {
        $this->respond(self::page([['id' => 1]], true));

        $items = $this->items()->getUpdatedSince(null);

        $this->assertRequest('GET', '/rest/items', ['page' => '1', 'with' => 'itemImages', 'updatedBetween' => self::DEFAULT_SINCE]);
        self::assertSame([1], self::ids($items));
    }

    // getVariation()

    public function testAVariationIsReadWithItsQuery(): void
    {
        $this->respond(self::fixture('Model/Item/ItemVariation'));

        $variation = $this->items()->getVariation(1601, 1598, ['with' => 'variationSalesPrices']);

        $this->assertRequest('GET', '/rest/items/1601/variations/1598', ['with' => 'variationSalesPrices']);
        self::assertInstanceOf(ItemVariation::class, $variation);
        self::assertSame([1598, 1601, 'value-610'], [$variation->getId(), $variation->getItemId(), $variation->getNumber()]);
    }

    public function testAVariationIsReadWithoutQuery(): void
    {
        $this->respond(['id' => 2, 'itemId' => 1]);

        $variation = $this->items()->getVariation(1, 2);

        $this->assertRequest('GET', '/rest/items/1/variations/2');
        self::assertSame('', $this->request()->getUri()->getQuery());
        self::assertSame(2, $variation->getId());
    }

    // getVariationDescriptions()

    public function testTheDescriptionsOfAVariationAreRead(): void
    {
        $this->respond([self::fixture('Model/Item/ItemVariationDescription'), ['itemId' => 1, 'lang' => 'en', 'name' => 'Tomato']]);

        $descriptions = $this->items()->getVariationDescriptions(1, 2);

        $this->assertRequest('GET', '/rest/items/1/variations/2/descriptions', []);
        self::assertContainsOnlyInstancesOf(ItemVariationDescription::class, $descriptions);
        self::assertSame([['value-1137', 'value-1138'], ['en', 'Tomato']], array_map(
            static fn (ItemVariationDescription $description): array => [$description->getLang(), $description->getName()],
            $descriptions,
        ));
    }

    // getVariationImages()

    public function testTheImagesOfAVariationAreRead(): void
    {
        $this->respond([self::fixture('Model/Item/ItemImage'), ['id' => 3, 'url' => 'https://example.test/3.jpg']]);

        $images = $this->items()->getVariationImages(1, 2);

        $this->assertRequest('GET', '/rest/items/1/variations/2/images', []);
        self::assertContainsOnlyInstancesOf(ItemImage::class, $images);
        self::assertSame([1536, 3], self::ids($images));
        self::assertSame(['value-551', 'https://example.test/3.jpg'], array_map(static fn (ItemImage $image): string => $image->getUrl(), $images));
    }

    // getVariationStock()

    public function testTheStockOfAVariationIsRead(): void
    {
        $this->respond([self::fixture('Model/Item/ItemVariationStock')]);

        $stock = $this->items()->getVariationStock(2178, 2179, false);

        $this->assertRequest('GET', '/rest/items/2178/variations/2179/stock', []);
        self::assertCount(1, $stock);
        self::assertInstanceOf(ItemVariationStock::class, $stock[0]);
        self::assertSame([2179, 2180, 2186.25], [$stock[0]->getVariationId(), $stock[0]->getWarehouseId(), $stock[0]->getNetStock()]);
    }

    // getVariationWarehouses()

    public function testTheWarehousesOfAVariationAreReadWithTheZeroDateFixed(): void
    {
        $this->respond([self::fixture('Model/Item/ItemVariationWarehouse'), ['variationId' => 2, 'warehouseId' => 3, 'lastUpdateTimestamp' => self::ZERO_DATE_LMT]]);

        $warehouses = $this->items()->getVariationWarehouses(1, 2);

        $this->assertRequest('GET', '/rest/items/1/variations/2/variation_warehouses', []);
        self::assertContainsOnlyInstancesOf(ItemVariationWarehouse::class, $warehouses);
        self::assertSame([2215, 3], array_map(static fn (ItemVariationWarehouse $warehouse): int => $warehouse->getWarehouseId(), $warehouses));
        self::assertSame(2217, $warehouses[0]->getReorderLevel());
        self::assertSame(self::ZERO_DATE, $warehouses[1]->getLastUpdateTimestamp()->format(DATE_ATOM));
    }

    // getVariationBarcodes()

    public function testTheBarcodesOfAVariationAreRead(): void
    {
        $this->respond([self::fixture('Model/Item/ItemVariationBarcode'), ['barcodeId' => 1, 'variationId' => 2, 'code' => '4006381333931']]);

        $barcodes = $this->items()->getVariationBarcodes(1, 2);

        $this->assertRequest('GET', '/rest/items/1/variations/2/variation_barcodes', []);
        self::assertContainsOnlyInstancesOf(ItemVariationBarcode::class, $barcodes);
        self::assertSame([[2102, 'value-1104'], [1, '4006381333931']], array_map(
            static fn (ItemVariationBarcode $barcode): array => [$barcode->getBarcodeId(), $barcode->getCode()],
            $barcodes,
        ));
    }

    // getVariationStockStorageLocations()

    public function testTheStorageLocationsOfAVariationAreReadPageByPage(): void
    {
        $this->respond(self::page([self::fixture('Model/Item/ItemVariationStockStorageLocation')], false), self::page([['storageLocationId' => 9, 'quantity' => 4]], true, 2));

        $locations = $this->items()->getVariationStockStorageLocations(1, 2, 1, ['warehouseId' => 3]);

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/items/1/variations/2/stock/storageLocations', ['page' => '1', 'itemsPerPage' => '200', 'warehouseId' => '3'], 0);
        $this->assertRequest('GET', '/rest/items/1/variations/2/stock/storageLocations', ['page' => '2', 'itemsPerPage' => '200', 'warehouseId' => '3'], 1);
        self::assertContainsOnlyInstancesOf(ItemVariationStockStorageLocation::class, $locations);
        self::assertSame([[2189, 2192], [9, 4]], array_map(
            static fn (ItemVariationStockStorageLocation $location): array => [$location->getStorageLocationId(), $location->getQuantity()],
            $locations,
        ));
    }

    public function testTheQueryCanChangeTheStorageLocationsPerPage(): void
    {
        $this->respond(self::page([], true));

        $locations = $this->items()->getVariationStockStorageLocations(1, 2, 1, ['itemsPerPage' => 10]);

        $this->assertRequest('GET', '/rest/items/1/variations/2/stock/storageLocations', ['page' => '1', 'itemsPerPage' => '10']);
        self::assertSame([], $locations);
    }

    public function testAFailingLaterStorageLocationPageIsLeftOut(): void
    {
        $this->respond(self::page([['storageLocationId' => 9]], false), self::notFound());

        $locations = $this->items()->getVariationStockStorageLocations(1, 2);

        $this->assertRequestCount(2);
        self::assertCount(1, $locations);
        self::assertSame(9, $locations[0]->getStorageLocationId());
    }

    // getVariationSalesPrices()

    public function testTheSalesPricesOfAVariationAreRead(): void
    {
        $this->respond([self::fixture('Model/Item/ItemVariationSalesPrice'), ['variationId' => 2, 'salesPriceId' => 1, 'price' => 2.49]]);

        $prices = $this->items()->getVariationSalesPrices(1, 2);

        $this->assertRequest('GET', '/rest/items/1/variations/2/variation_sales_prices', []);
        self::assertContainsOnlyInstancesOf(ItemVariationSalesPrice::class, $prices);
        self::assertSame([[2157, 2158.25], [1, 2.49]], array_map(
            static fn (ItemVariationSalesPrice $price): array => [$price->getSalesPriceId(), $price->getPrice()],
            $prices,
        ));
    }

    public function testTheZeroDateOfASalesPriceIsNotFixedAndRefused(): void
    {
        $this->respond([['variationId' => 2, 'salesPriceId' => 1, 'updatedAt' => self::ZERO_DATE]]);

        $this->expectException(RuntimeException::class);

        $this->items()->getVariationSalesPrices(1, 2);
    }

    // getVariationSuppliers()

    public function testTheSuppliersOfAVariationAreReadWithTheZeroDateFixed(): void
    {
        $this->respond([self::fixture('Model/Item/ItemVariationSupplier'), ['id' => 3, 'supplierId' => 4, 'lastUpdateTimestamp' => self::ZERO_DATE_LMT]]);

        $suppliers = $this->items()->getVariationSuppliers(1, 2);

        $this->assertRequest('GET', '/rest/items/1/variations/2/variation_suppliers', []);
        self::assertContainsOnlyInstancesOf(ItemVariationSupplier::class, $suppliers);
        self::assertSame([[2197, 2199, 'value-1202'], [3, 4, null]], array_map(
            static fn (ItemVariationSupplier $supplier): array => [$supplier->getId(), $supplier->getSupplierId(), $supplier->getItemNumber()],
            $suppliers,
        ));
        self::assertSame(self::ZERO_DATE, $suppliers[1]->getLastUpdateTimestamp()->format(DATE_ATOM));
    }

    // getVariationsUpdatedSince(), getVariationsRelatedUpdatedSince()

    /** @return iterable<string, array{string, string}> */
    public static function variationsSince(): iterable
    {
        yield 'getVariationsUpdatedSince' => ['getVariationsUpdatedSince', 'updatedBetween'];
        yield 'getVariationsRelatedUpdatedSince' => ['getVariationsRelatedUpdatedSince', 'relatedUpdatedBetween'];
    }

    #[DataProvider('variationsSince')]
    public function testVariationsSinceADateAreAskedForWithItsTimestampAndRelations(string $method, string $filter): void
    {
        $this->respond(self::page([['id' => 11]], false), self::page([['id' => 12]], true, 2));

        $variations = $this->items()->{$method}(new DateTimeImmutable('2026-03-02T10:14:00+01:00'), ['stock', 'variationSalesPrices']);

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/items/variations', ['page' => '1', $filter => '1772442840', 'with' => 'stock,variationSalesPrices'], 0);
        $this->assertRequest('GET', '/rest/items/variations', ['page' => '2', $filter => '1772442840', 'with' => 'stock,variationSalesPrices'], 1);
        self::assertContainsOnlyInstancesOf(ItemVariation::class, $variations);
        self::assertSame([11, 12], self::ids($variations));
    }

    #[DataProvider('variationsSince')]
    public function testVariationsSinceNoDateAreAskedForSince2020WithoutRelations(string $method, string $filter): void
    {
        $this->respond(self::page([['id' => 11]], true));

        $variations = $this->items()->{$method}(null);

        $this->assertRequest('GET', '/rest/items/variations', ['page' => '1', $filter => self::DEFAULT_SINCE]);
        self::assertSame([11], self::ids($variations));
    }

    // putStockCorrection()

    public function testAStockCorrectionIsBookedAsACorrectionByDefault(): void
    {
        $this->respond('');

        $result = $this->items()->putStockCorrection(1, 2, 5, 3, 4);

        $this->assertRequest('PUT', '/rest/items/1/variations/2/stock/correction', []);
        self::assertSame(['quantity' => 5, 'warehouseId' => 3, 'storageLocationId' => 4, 'reasonId' => 301], $this->body());
        self::assertTrue($result);
    }

    public function testAStockCorrectionIsBookedWithTheGivenReason(): void
    {
        $this->respond('');

        $this->items()->putStockCorrection(1, 2, -1, 3, 4, Item::REASON_STOCK_CORRECTION_PACKING_ERROR);

        self::assertSame(['quantity' => -1, 'warehouseId' => 3, 'storageLocationId' => 4, 'reasonId' => 306], $this->body());
    }

    // putBookIncomingItems()

    public function testIncomingItemsAreBookedInEuroAsDeliveredNow(): void
    {
        $this->respond('');
        $before = time();

        $result = $this->items()->putBookIncomingItems(1, 2, 5, 3, 4);

        $this->assertRequest('PUT', '/rest/items/1/variations/2/stock/bookIncomingItems', []);
        $body = $this->body();
        self::assertSame(['currency', 'deliveredAt', 'quantity', 'warehouseId', 'storageLocationId', 'reasonId'], array_keys($body));
        self::assertSame(['currency' => 'EUR', 'quantity' => 5, 'warehouseId' => 3, 'storageLocationId' => 4, 'reasonId' => 101], array_diff_key($body, ['deliveredAt' => true]));
        $deliveredAt = DateTimeImmutable::createFromFormat(DATE_ATOM, $body['deliveredAt']);
        self::assertNotFalse($deliveredAt, 'date("c"): '.$body['deliveredAt']);
        self::assertGreaterThanOrEqual($before, $deliveredAt->getTimestamp());
        self::assertLessThanOrEqual(time(), $deliveredAt->getTimestamp());
        self::assertTrue($result);
    }

    // putStockRedistribute()

    public function testARedistributionIsSentToTheVariation(): void
    {
        $this->respond('');

        $result = $this->items()->putStockRedistribute(1, 2, 5, null, null, 6, 7);

        $this->assertRequest('PUT', '/rest/items/1/variations/2', []);
        self::assertSame([
            'reasonId' => 401,
            'quantity' => 5,
            'currentStorageLocationId' => null,
            'currentWarehouseId' => null,
            'newStorageLocationId' => 6,
            'newWarehouseId' => 7,
        ], $this->body());
        self::assertTrue($result);
    }

    // getUnits()

    public function testUnitsAreReadPageByPage(): void
    {
        $this->respond(self::page([self::fixture('Model/Item/Unit')], false), self::page([['id' => 2, 'unitOfMeasurement' => 'KGM']], true, 2));

        $units = $this->items()->getUnits();

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/items/units', ['page' => '1', 'itemsPerPage' => '250'], 0);
        $this->assertRequest('GET', '/rest/items/units', ['page' => '2', 'itemsPerPage' => '250'], 1);
        self::assertContainsOnlyInstancesOf(Unit::class, $units);
        self::assertSame([[2384, 'value-1385'], [2, 'KGM']], array_map(static fn (Unit $unit): array => [$unit->getId(), $unit->getUnitOfMeasurement()], $units));
    }

    public function testUnitsStopAtAPageThatDoesNotSayItIsNotTheLast(): void
    {
        $this->respond(self::page([['id' => 1]], null));

        $units = $this->items()->getUnits();

        $this->assertRequestCount(1);
        self::assertSame([1], self::ids($units));
    }

    public function testAFailingLaterUnitPageDropsTheUnitsRead(): void
    {
        $error = self::notFound();
        $this->respond(self::page([['id' => 1]], false), $error);

        $result = $this->items()->getUnits();

        $this->assertRequestCount(2);
        self::assertSame($error, $result);
    }

    // putVariationFields()

    public function testFieldsOfAVariationAreSent(): void
    {
        $this->respond('');

        $result = $this->items()->putVariationFields(1, 2, ['isActive' => false, 'number' => 'T-1']);

        $this->assertRequest('PUT', '/rest/items/1/variations/2', []);
        self::assertSame(['isActive' => false, 'number' => 'T-1'], $this->body());
        self::assertNull($result);
    }

    // putItemField()

    public function testAFieldOfAnItemIsSentAsAString(): void
    {
        $this->respond('');

        $result = $this->items()->putItemField(1, 'free1', '42');

        $this->assertRequest('PUT', '/rest/items/1', []);
        self::assertSame(['free1' => '42'], $this->body());
        self::assertNull($result);
    }

    // putReorderLevel()

    public function testAReorderLevelIsChangedInItsWarehouse(): void
    {
        $this->respond('');

        $result = $this->items()->putReorderLevel(1, 2, 3, 10);

        $this->assertRequest('PUT', '/rest/items/1/variations/2/variation_warehouses/3', []);
        self::assertSame(['reorderLevel' => 10], $this->body());
        self::assertTrue($result);
    }

    // postReorderLevel()

    public function testAReorderLevelIsCreatedAsAForm(): void
    {
        $this->respond('');

        $result = $this->items()->postReorderLevel(1, 2, 3, 10);

        $this->assertRequest('POST', '/rest/items/1/variations/2/variation_warehouses', []);
        self::assertSame('application/x-www-form-urlencoded', $this->request()->getHeaderLine('Content-Type'));
        self::assertSame('warehouseId=3&reorderLevel=10', (string) $this->request()->getBody());
        self::assertTrue($result);
    }

    // putShopPosition()

    public function testAShopPositionIsSentToTheVariation(): void
    {
        $this->respond('');

        $result = $this->items()->putShopPosition(1, 2, 15);

        $this->assertRequest('PUT', '/rest/items/1/variations/2', []);
        self::assertSame(['position' => 15], $this->body());
        self::assertTrue($result);
    }

    // The error answers

    /** @return iterable<string, array{Closure(ItemsProvider): mixed}> */
    public static function returnTheError(): iterable
    {
        yield 'getAll' => [static fn (ItemsProvider $items): mixed => $items->getAll()];
        yield 'getVariationsPage' => [static fn (ItemsProvider $items): mixed => $items->getVariationsPage()];
        yield 'getAllVariations' => [static fn (ItemsProvider $items): mixed => $items->getAllVariations()];
        yield 'getBarcodes' => [static fn (ItemsProvider $items): mixed => $items->getBarcodes()];
        yield 'getById' => [static fn (ItemsProvider $items): mixed => $items->getById(1)];
        yield 'getManufacturers' => [static fn (ItemsProvider $items): mixed => $items->getManufacturers()];
        yield 'getShippingProfiles' => [static fn (ItemsProvider $items): mixed => $items->getShippingProfiles(1)];
        yield 'getVariation' => [static fn (ItemsProvider $items): mixed => $items->getVariation(1, 2)];
        yield 'getVariationDescriptions' => [static fn (ItemsProvider $items): mixed => $items->getVariationDescriptions(1, 2)];
        yield 'getVariationWarehouses' => [static fn (ItemsProvider $items): mixed => $items->getVariationWarehouses(1, 2)];
        yield 'getVariationStockStorageLocations' => [static fn (ItemsProvider $items): mixed => $items->getVariationStockStorageLocations(1, 2)];
        yield 'getVariationSalesPrices' => [static fn (ItemsProvider $items): mixed => $items->getVariationSalesPrices(1, 2)];
        yield 'getVariationSuppliers' => [static fn (ItemsProvider $items): mixed => $items->getVariationSuppliers(1, 2)];
        yield 'getUnits' => [static fn (ItemsProvider $items): mixed => $items->getUnits()];
        yield 'putStockCorrection' => [static fn (ItemsProvider $items): mixed => $items->putStockCorrection(1, 2, 5, 3, 4)];
        yield 'putBookIncomingItems' => [static fn (ItemsProvider $items): mixed => $items->putBookIncomingItems(1, 2, 5, 3, 4)];
        yield 'putStockRedistribute' => [static fn (ItemsProvider $items): mixed => $items->putStockRedistribute(1, 2, 5, 3, 4, 6, 7)];
        yield 'putVariationFields' => [static fn (ItemsProvider $items): mixed => $items->putVariationFields(1, 2, ['isActive' => true])];
        yield 'putItemField' => [static fn (ItemsProvider $items): mixed => $items->putItemField(1, 'free1', '42')];
        yield 'putReorderLevel' => [static fn (ItemsProvider $items): mixed => $items->putReorderLevel(1, 2, 3, 10)];
        yield 'postReorderLevel' => [static fn (ItemsProvider $items): mixed => $items->postReorderLevel(1, 2, 3, 10)];
        yield 'putShopPosition' => [static fn (ItemsProvider $items): mixed => $items->putShopPosition(1, 2, 15)];
    }

    /** @param Closure(ItemsProvider): mixed $call */
    #[DataProvider('returnTheError')]
    public function testAnErrorAnswerIsReturned(Closure $call): void
    {
        $error = self::notFound();
        $this->respond($error);

        $result = $call($this->items());

        $this->assertRequestCount(1);
        self::assertSame($error, $result);
    }

    /** @return iterable<string, array{Closure(ItemsProvider): mixed}> */
    public static function throwTheError(): iterable
    {
        yield 'getSalesPrice' => [static fn (ItemsProvider $items): mixed => $items->getSalesPrice(1)];
        yield 'getUpdatedSince' => [static fn (ItemsProvider $items): mixed => $items->getUpdatedSince(null)];
        yield 'getVariationImages' => [static fn (ItemsProvider $items): mixed => $items->getVariationImages(1, 2)];
        yield 'getVariationStock' => [static fn (ItemsProvider $items): mixed => $items->getVariationStock(1, 2)];
        yield 'getVariationBarcodes' => [static fn (ItemsProvider $items): mixed => $items->getVariationBarcodes(1, 2)];
        yield 'getVariationsUpdatedSince' => [static fn (ItemsProvider $items): mixed => $items->getVariationsUpdatedSince(null)];
        yield 'getVariationsRelatedUpdatedSince' => [static fn (ItemsProvider $items): mixed => $items->getVariationsRelatedUpdatedSince(null)];
    }

    /** @param Closure(ItemsProvider): mixed $call */
    #[DataProvider('throwTheError')]
    public function testAnErrorAnswerIsThrown(Closure $call): void
    {
        $error = self::notFound();
        $this->respond($error);

        try {
            $call($this->items());
            self::fail('The error was not thrown.');
        } catch (Throwable $thrown) {
            self::assertSame($error, $thrown);
        }
        $this->assertRequestCount(1);
    }

    private function items(): ItemsProvider
    {
        return $this->service->items($this->config());
    }

    /** @return array<string, mixed> a page of plentymarkets with these entries */
    private static function page(array $entries, ?bool $last, int $page = 1): array
    {
        return ['page' => $page, 'totalsCount' => 3, 'isLastPage' => $last, 'entries' => $entries];
    }

    private static function notFound(): ClientException
    {
        return ClientException::create(
            new Request('GET', 'https://p12345.my.plentysystems.com/rest/items'),
            new Response(404, [], '{"error":{"message":"not found"}}'),
        );
    }

    /** @return list<int> */
    private static function ids(array $models): array
    {
        return array_map(static fn (object $model): int => $model->getId(), $models);
    }
}
