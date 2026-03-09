<?php

namespace PM\PlentyMarketsBundle\Component\Provider;

use DateTime;
use DateTimeInterface;
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
use PM\PlentyMarketsBundle\Component\Response\ItemLocationsResponse;
use PM\PlentyMarketsBundle\Component\Response\ItemsBarcodesResponse;
use PM\PlentyMarketsBundle\Component\Response\ItemsResponse;
use PM\PlentyMarketsBundle\Component\Response\ItemsVariationsResponse;
use PM\PlentyMarketsBundle\Component\Response\ManufacturersResponse;
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
                    $query
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
                    $query
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

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), sprintf('array<%s>', ItemShippingProfile::class), 'json');
    }

    public function getUpdatedSince(?DateTimeInterface $since): array
    {
        $query = [
            'with' => 'itemImages',
        ];

        if (null !== $since) {
            $query['updatedBetween'] = $since->getTimestamp();
        } else {
            $query['updatedBetween'] = (new DateTime('2020-01-01'))->getTimestamp();
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

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), sprintf('array<%s>', ItemVariationDescription::class), 'json');
    }

    public function getVariationImages(int $itemId, int $variationId): array
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_VARIATION_IMAGES, $itemId, $variationId));
        if ($response instanceof Throwable) {
            throw $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), sprintf('array<%s>', ItemImage::class), 'json');
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

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), sprintf('array<%s>', ItemVariationStock::class), 'json');
    }

    public function getVariationWarehouses(int $itemId, int $variationId): array|Throwable
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_VARIATION_WAREHOUSES, $itemId, $variationId));
        if ($response instanceof Throwable) {
            return $response;
        }

        $body = $this->getBodyContentsWithFixedDate($response);

        return $this->getService()->getSerializer()->deserialize($body, sprintf('array<%s>', ItemVariationWarehouse::class), 'json');
    }

    public function getVariationBarcodes(int $itemId, int $variationId): array
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ITEM_VARIATION_BARCODES, $itemId, $variationId));
        if ($response instanceof Throwable) {
            throw $response;
        }

        return $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            sprintf('array<%s>', ItemVariationBarcode::class),
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
                    $query
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
            sprintf('array<%s>', ItemVariationSalesPrice::class),
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

        return $this->getService()->getSerializer()->deserialize($body, sprintf('array<%s>', ItemVariationSupplier::class), 'json');
    }

    public function getVariationsUpdatedSince(?DateTimeInterface $since): array
    {
        $query = [];
        if (null !== $since) {
            $query['updatedBetween'] = $since->getTimestamp();
        } else {
            $query['updatedBetween'] = (new DateTime('2020-01-01'))->getTimestamp();
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
            $query['relatedUpdatedBetween'] = (new DateTime('2020-01-01'))->getTimestamp();
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

    public function putStockCorrection(int $itemId, int $variationId, int $quantity, int $warehouseId, int $storageLocationId, int $reason = Item::REASON_STOCK_CORRECTION): bool|Throwable
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

    public function putBookIncomingItems(int $itemId, int $variationId, int $quantity, int $warehouseId, int $storageLocationId, int $reason = Item::REASON_INCOMING_ITEMS): bool|Throwable
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
        int $quantity,
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
