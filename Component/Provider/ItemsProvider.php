<?php

namespace PM\PlentyMarketsBundle\Component\Provider;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use GuzzleHttp\RequestOptions;
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
use PM\PlentyMarketsBundle\Component\Response\ItemLocationsResponse;
use PM\PlentyMarketsBundle\Component\Response\ItemsBarcodesResponse;
use PM\PlentyMarketsBundle\Component\Response\ItemsResponse;
use PM\PlentyMarketsBundle\Component\Response\ItemsVariationsResponse;
use PM\PlentyMarketsBundle\Component\Response\ManufacturersResponse;
use PM\PlentyMarketsBundle\Component\Response\UnitsResponse;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;
use Throwable;


class ItemsProvider extends BaseProvider
{
    public function getAll(int $page = 1, array $query = []): array|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::ITEMS,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ],
                    $query,
                    // The page of the argument, whatever $query says (#60).
                    ['page' => $page]
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        /** @var ItemsResponse $data */
        $data = $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ItemsResponse::class, 'json');

        if (true === $data->isIsLastPage()) {
            return $data->getEntries();
        }

        /* Get other pages */
        $merged = $this->getAll($page + 1, $query);
        if ($merged instanceof Throwable) {
            $this->getService()->getLogger()->error(
                'ItemsProvider:getAll got some exception importing more pages',
                [
                    'message' => $merged->getMessage(),
                ]
            );

            $merged = [];
        }

        return array_merge($data->getEntries(), $merged);
    }

    /**
     * A single page of items, for result sets too large to keep in memory.
     */
    public function getItemsPage(int $page = 1, array $query = []): ItemsResponse|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::ITEMS,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ],
                    $query,
                    // The page of the argument, whatever $query says (#60).
                    ['page' => $page]
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ItemsResponse::class, 'json');
    }

    /**
     * A single page, for result sets too large to keep in memory.
     */
    public function getVariationsPage(int $page = 1, array $query = []): ItemsVariationsResponse|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::ITEM_VARIATIONS,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ],
                    $query,
                    // The page of the argument, whatever $query says (#60).
                    ['page' => $page]
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($this->getBodyContentsWithFixedDate($response), ItemsVariationsResponse::class, 'json');
    }

    public function getAllVariations(int $page = 1, array $query = []): array|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::ITEM_VARIATIONS,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ],
                    $query,
                    // The page of the argument, whatever $query says (#60).
                    ['page' => $page]
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        $body = $this->getBodyContentsWithFixedDate($response);

        /** @var ItemsVariationsResponse $data */
        $data = $this->getService()->getSerializer()->deserialize($body, ItemsVariationsResponse::class, 'json');

        if (true === $data->isIsLastPage()) {
            return $data->getEntries();
        }

        /* Get other pages */
        $merged = $this->getAllVariations($page + 1, $query);
        if ($merged instanceof Throwable) {
            $this->getService()->getLogger()->error(
                'ItemsProvider:getAllVariations got some exception importing more pages',
                [
                    'message' => $merged->getMessage(),
                ]
            );

            $merged = [];
        }

        return array_merge($data->getEntries(), $merged);
    }

    public function getAllWithVariations(): array|Throwable
    {
        return array_reverse(
            $this->getAll(
                1,
                [
                    'with' => 'variations',
                ]
            )
        );
    }

    public function getAllWithVariationsAndImages(): array|Throwable
    {
        return array_reverse(
            $this->getAll(
                1,
                [
                    'with' => 'variations,itemImages',
                ]
            )
        );
    }

    public function getBarcodes(int $page = 1): array|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::ITEM_BARCODES,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ]
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        /** @var ManufacturersResponse $data */
        $data = $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            ItemsBarcodesResponse::class,
            'json'
        );

        if (true === $data->isIsLastPage()) {
            return $data->getEntries();
        }

        return array_merge($data->getEntries(), $this->getBarcodes($page + 1));
    }

    public function getById(int $itemId, array $query = []): Throwable|Item
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            sprintf(RestfulUrl::ITEM, $itemId),
            [
                'query' => $query,
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), Item::class, 'json');
    }

    public function getManufacturers(int $page = 1): array|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::ITEM_MANUFACTURERS,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ]
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        /** @var ManufacturersResponse $data */
        $data = $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            ManufacturersResponse::class,
            'json'
        );

        if (true === $data->isIsLastPage()) {
            return $data->getEntries();
        }

        return array_merge($data->getEntries(), $this->getManufacturers($page + 1));
    }

    public function getSalesPrice(int $salePriceId): ?SalesPrice
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_SALES_PRICE, $salePriceId));
        if ($response instanceof Throwable) {
            throw $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), SalesPrice::class, 'json');
    }

    public function getShippingProfiles(int $itemId): array|Throwable
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_SHIPPING_PROFILES, $itemId));
        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ItemShippingProfile::class.'[]', 'json');
    }

    public function getUpdatedSince(?DateTimeInterface $since): array
    {
        $query = [
            'with' => 'itemImages',
        ];

        if (null !== $since) {
            $query['updatedBetween'] = $since->getTimestamp();
        } else {
            $query['updatedBetween'] = (new DateTime('2020-01-01', new DateTimeZone('UTC')))->getTimestamp();
        }

        $result = $this->getAll(1, $query);
        if ($result instanceof Throwable) {
            throw $result;
        }

        return $result;
    }

    public function getVariation(int $itemId, int $variationId, ?array $query = null): Throwable|ItemVariation
    {
        $options = [];

        if (null !== $query) {
            $options['query'] = $query;
        }

        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_VARIATION, $itemId, $variationId), $options);

        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ItemVariation::class, 'json');
    }

    public function getVariationDescriptions(int $itemId, int $variationId): Throwable|array
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_VARIATION_DESCRIPTIONS, $itemId, $variationId));
        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ItemVariationDescription::class.'[]', 'json');
    }

    public function getVariationImages(int $itemId, int $variationId): array
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_VARIATION_IMAGES, $itemId, $variationId));
        if ($response instanceof Throwable) {
            throw $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ItemImage::class.'[]', 'json');
    }

    /**
     * Uploads an image to the item. Without availabilities plentymarkets makes it available
     * for all clients, markets and listings; an empty list keeps it unavailable everywhere.
     * POST items/{id}/images (without /upload) answers 200 and creates nothing.
     *
     * @param string                                                 $data           the file itself, not base64
     * @param ?list<array{type: string, value: float|int}>           $availabilities null = the default of plentymarkets
     */
    public function uploadImage(int $itemId, string $fileName, string $data, string $fileType, int $position = 0, ?array $availabilities = []): ItemImage|Throwable
    {
        $body = [
            'itemId' => $itemId,
            'uploadFileName' => $fileName,
            'uploadImageData' => base64_encode($data),
            'fileType' => $fileType,
            'position' => $position,
        ];
        if (null !== $availabilities) {
            $body['availabilities'] = $availabilities;
        }

        $response = $this->getResponse(Request::METHOD_POST, sprintf(RestfulUrl::ITEM_IMAGE_UPLOAD, $itemId), [RequestOptions::JSON => $body]);
        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ItemImage::class, 'json');
    }

    /**
     * Links an image of the item to one of its variations.
     */
    public function postVariationImage(int $itemId, int $variationId, int $imageId): ?Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_POST,
            sprintf(RestfulUrl::ITEM_VARIATION_IMAGE_LINKS, $itemId, $variationId),
            [
                RequestOptions::JSON => [
                    'itemId' => $itemId,
                    'variationId' => $variationId,
                    'imageId' => $imageId,
                ],
            ]
        );

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Deletes an image of the item, its links to variations go with it.
     */
    public function deleteImage(int $itemId, int $imageId): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_DELETE, sprintf(RestfulUrl::ITEM_IMAGE, $itemId, $imageId));

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Changes fields of the image, such as names: [['lang' => 'de', 'name' => '', 'alternate' => '…']]
     * (only languages the image has already).
     *
     * @param array<string, mixed> $fields
     */
    public function putImage(int $itemId, int $imageId, array $fields): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_PUT, sprintf(RestfulUrl::ITEM_IMAGE, $itemId, $imageId), [RequestOptions::JSON => $fields]);

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Changes fields of the item, such as flagOne, storeSpecial or free11; the others stay.
     *
     * @param array<string, mixed> $fields
     */
    public function putItemFields(int $itemId, array $fields): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_PUT, sprintf(RestfulUrl::ITEM, $itemId), [RequestOptions::JSON => $fields]);

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Changes the description of a variation in one language: only the fields given, name 1 is name.
     *
     * @param array<string, mixed> $fields
     */
    public function putVariationDescription(int $itemId, int $variationId, string $lang, array $fields): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_PUT, sprintf(RestfulUrl::ITEM_VARIATION_DESCRIPTION, $itemId, $variationId, $lang), [RequestOptions::JSON => $fields]);

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Gives the variation a sales price it does not have yet.
     */
    public function postVariationSalesPrice(int $itemId, int $variationId, int $salesPriceId, float $price): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_POST, sprintf(RestfulUrl::ITEM_VARIATION_SALES_PRICES, $itemId, $variationId), [RequestOptions::JSON => ['salesPriceId' => $salesPriceId, 'price' => $price]]);

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Changes a sales price of the variation, such as price or lowestPriceCalculation.
     *
     * @param array<string, mixed> $fields
     */
    public function putVariationSalesPrice(int $itemId, int $variationId, int $salesPriceId, array $fields): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_PUT, sprintf(RestfulUrl::ITEM_VARIATION_SALES_PRICE, $itemId, $variationId, $salesPriceId), [RequestOptions::JSON => $fields]);

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Takes a sales price from the variation.
     */
    public function deleteVariationSalesPrice(int $itemId, int $variationId, int $salesPriceId): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_DELETE, sprintf(RestfulUrl::ITEM_VARIATION_SALES_PRICE, $itemId, $variationId, $salesPriceId));

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Links the variation to a category.
     */
    public function postVariationCategory(int $itemId, int $variationId, int $categoryId): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_POST, sprintf(RestfulUrl::ITEM_VARIATION_CATEGORIES, $itemId, $variationId), [RequestOptions::JSON => ['categoryId' => $categoryId]]);

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Removes the link of the variation to a category.
     */
    public function deleteVariationCategory(int $itemId, int $variationId, int $categoryId): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_DELETE, sprintf(RestfulUrl::ITEM_VARIATION_CATEGORY, $itemId, $variationId, $categoryId));

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Links the variation to a market (referrer), sub-referrers such as 4.01 included.
     */
    public function postVariationMarket(int $itemId, int $variationId, float $marketId): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_POST, sprintf(RestfulUrl::ITEM_VARIATION_MARKETS, $itemId, $variationId), [RequestOptions::JSON => ['marketId' => $marketId]]);

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Removes the link of the variation to a market (referrer): 4 for 4.0, 4.01 as it is.
     */
    public function deleteVariationMarket(int $itemId, int $variationId, float $marketId): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_DELETE, sprintf(RestfulUrl::ITEM_VARIATION_MARKET, $itemId, $variationId, $marketId));

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Changes fields of a supplier of the variation, such as deliveryTimeInDays; the id is
     * the one of the link (ItemVariationSupplier::getId()), not the supplier's.
     *
     * @param array<string, mixed> $fields
     */
    public function putVariationSupplier(int $itemId, int $variationId, int $variationSupplierId, array $fields): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_PUT, sprintf(RestfulUrl::ITEM_VARIATION_SUPPLIER, $itemId, $variationId, $variationSupplierId), [RequestOptions::JSON => $fields]);

        return $response instanceof Throwable ? $response : null;
    }

    /**
     * Changes fields of the variation in a warehouse, such as storageLocation.
     *
     * @param array<string, mixed> $fields
     */
    public function putVariationWarehouse(int $itemId, int $variationId, int $warehouseId, array $fields): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_PUT, sprintf(RestfulUrl::ITEM_VARIATION_WAREHOUSES_WAREHOUSE, $itemId, $variationId, $warehouseId), [RequestOptions::JSON => $fields]);

        return $response instanceof Throwable ? $response : null;
    }

    public function getVariationStock(int $itemId, int $variationId, bool $flushEntities = true): array
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            sprintf(RestfulUrl::ITEM_VARIATION_STOCK, $itemId, $variationId),
            [],
            false,
            false,
            $flushEntities
        );
        if ($response instanceof Throwable) {
            throw $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ItemVariationStock::class.'[]', 'json');
    }

    public function getVariationWarehouses(int $itemId, int $variationId): array|Throwable
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_VARIATION_WAREHOUSES, $itemId, $variationId));
        if ($response instanceof Throwable) {
            return $response;
        }

        $body = $this->getBodyContentsWithFixedDate($response);

        return $this->getService()->getSerializer()->deserialize($body, ItemVariationWarehouse::class.'[]', 'json');
    }

    public function getVariationBarcodes(int $itemId, int $variationId): array
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_VARIATION_BARCODES, $itemId, $variationId));
        if ($response instanceof Throwable) {
            throw $response;
        }

        return $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            ItemVariationBarcode::class.'[]',
            'json'
        );
    }

    public function getVariationStockStorageLocations(int $itemId, int $variationId, $page = 1, array $query = []): array|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            sprintf(RestfulUrl::ITEM_VARIATION_STOCK_STORAGE_LOCATIONS, $itemId, $variationId),
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                        'itemsPerPage' => 200,
                    ],
                    $query,
                    // The page of the argument, whatever $query says (#60).
                    ['page' => $page]
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        /** @var ItemLocationsResponse $data */
        $data = $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            ItemLocationsResponse::class,
            'json'
        );

        if (true === $data->isIsLastPage()) {
            return $data->getEntries();
        }

        /* Get other pages */
        $merged = $this->getVariationStockStorageLocations($itemId, $variationId, $page + 1, $query);
        if ($merged instanceof Throwable) {
            $this->getService()->getLogger()->error(
                'ItemsProvider:getVariationStockStorageLocations got some exception importing more pages',
                [
                    'message' => $merged->getMessage(),
                ]
            );

            $merged = [];
        }

        return array_merge($data->getEntries(), $merged);
    }

    public function getVariationSalesPrices(int $itemId, int $variationId): array|Throwable
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_VARIATION_SALES_PRICES, $itemId, $variationId));
        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            ItemVariationSalesPrice::class.'[]',
            'json'
        );
    }

    public function getVariationSuppliers(int $itemId, int $variationId): array|Throwable
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_VARIATION_SUPPLIERS, $itemId, $variationId));
        if ($response instanceof Throwable) {
            return $response;
        }

        $body = $this->getBodyContentsWithFixedDate($response);

        return $this->getService()->getSerializer()->deserialize($body, ItemVariationSupplier::class.'[]', 'json');
    }

    public function getVariationsUpdatedSince(?DateTimeInterface $since, array $with = []): array
    {
        $query = [];
        if (null !== $since) {
            $query['updatedBetween'] = $since->getTimestamp();
        } else {
            $query['updatedBetween'] = (new DateTime('2020-01-01', new DateTimeZone('UTC')))->getTimestamp();
        }

        if (0 < count($with)) {
            $query['with'] = implode(',', $with);
        }

        $result = $this->getAllVariations(1, $query);
        if ($result instanceof Throwable) {
            throw $result;
        }

        return $result;
    }

    public function getVariationsRelatedUpdatedSince(?DateTimeInterface $since, array $with = []): array
    {
        $query = [];
        if (null !== $since) {
            $query['relatedUpdatedBetween'] = $since->getTimestamp();
        } else {
            $query['relatedUpdatedBetween'] = (new DateTime('2020-01-01', new DateTimeZone('UTC')))->getTimestamp();
        }

        if (0 < count($with)) {
            $query['with'] = implode(',', $with);
        }

        $result = $this->getAllVariations(1, $query);
        if ($result instanceof Throwable) {
            throw $result;
        }

        return $result;
    }

    public function putStockCorrection(int $itemId, int $variationId, float $quantity, int $warehouseId, int $storageLocationId, int $reason = Item::REASON_STOCK_CORRECTION): bool|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::ITEM_VARIATION_STOCK_CORRECTION, $itemId, $variationId),
            [
                RequestOptions::JSON => [
                    'quantity' => $quantity,
                    'warehouseId' => $warehouseId,
                    'storageLocationId' => $storageLocationId,
                    'reasonId' => $reason,
                ],
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return true;
    }

    public function putBookIncomingItems(int $itemId, int $variationId, float $quantity, int $warehouseId, int $storageLocationId, int $reason = Item::REASON_INCOMING_ITEMS): bool|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::ITEM_VARIATION_BOOK_INCOMING_ITEMS, $itemId, $variationId),
            [
                RequestOptions::JSON => [
                    'currency' => 'EUR',
                    'deliveredAt' => date('c'),
                    'quantity' => $quantity,
                    'warehouseId' => $warehouseId,
                    'storageLocationId' => $storageLocationId,
                    'reasonId' => $reason,
                ],
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return true;
    }

    public function putStockRedistribute(
        int $itemId,
        int $variationId,
        float $quantity,
        ?int $currentStorageLocationId,
        ?int $currentWarehouseId,
        int $newStorageLocationId,
        int $newWarehouseId,
        $reason = Item::REASON_STOCK_REDISTRIBUTE
    ): bool|Throwable {
        $request = [
            'reasonId' => $reason,
            'quantity' => $quantity,
            'currentStorageLocationId' => $currentStorageLocationId,
            'currentWarehouseId' => $currentWarehouseId,
            'newStorageLocationId' => $newStorageLocationId,
            'newWarehouseId' => $newWarehouseId,
        ];

        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::ITEM_VARIATION, $itemId, $variationId),
            [
                RequestOptions::JSON => $request,
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return true;
    }

    /**
     * @return Unit[]|Throwable
     */
    public function getUnits(): array|Throwable
    {
        $units = [];
        $page = 1;

        do {
            $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::ITEM_UNITS, ['query' => ['page' => $page, 'itemsPerPage' => 250]]);
            if ($response instanceof Throwable) {
                return $response;
            }

            /** @var UnitsResponse $data */
            $data = $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), UnitsResponse::class, 'json');
            array_push($units, ...$data->getEntries());

            ++$page;
        } while (false === $data->isIsLastPage());

        return $units;
    }

    /**
     * @param array<string, mixed> $fields
     */
    public function putVariationFields(int $itemId, int $variationId, array $fields): ?Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::ITEM_VARIATION, $itemId, $variationId),
            [
                RequestOptions::JSON => $fields,
            ]
        );

        return $response instanceof Throwable ? $response : null;
    }

    public function putItemField(int $itemId, string $field, string $value): ?Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::ITEM, $itemId),
            [
                RequestOptions::JSON => [
                    $field => $value,
                ],
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return null;
    }

    public function putReorderLevel(int $itemId, int $variationId, int $warehouseId, int $reorderLevel): bool|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::ITEM_VARIATION_WAREHOUSES_WAREHOUSE, $itemId, $variationId, $warehouseId),
            [
                RequestOptions::JSON => [
                    'reorderLevel' => $reorderLevel,
                ],
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return true;
    }

    public function postReorderLevel(int $itemId, int $variationId, int $warehouseId, int $reorderLevel): bool|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_POST,
            sprintf(RestfulUrl::ITEM_VARIATION_WAREHOUSES, $itemId, $variationId),
            [
                RequestOptions::FORM_PARAMS => [
                    'warehouseId' => $warehouseId,
                    'reorderLevel' => $reorderLevel,
                ],
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return true;
    }

    public function putShopPosition(int $itemId, int $variationId, int $position): bool|Throwable
    {
        $request = [
            'position' => $position,
        ];

        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::ITEM_VARIATION, $itemId, $variationId),
            [
                RequestOptions::JSON => $request,
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return true;
    }
}
