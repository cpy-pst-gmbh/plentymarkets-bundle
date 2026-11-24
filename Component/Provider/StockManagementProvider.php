<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 26.07.2017
 * Time: 13:46
 */

namespace PM\PlentyMarketsBundle\Component\Provider;

use DateTimeInterface;
use Exception;
use PM\PlentyMarketsBundle\Component\Model\StockManagement\StockMovement;
use PM\PlentyMarketsBundle\Component\Model\StockManagement\Warehouse;
use PM\PlentyMarketsBundle\Component\Response\ItemLocationsResponse;
use PM\PlentyMarketsBundle\Component\Response\StockMovementsResponse;
use PM\PlentyMarketsBundle\Component\Response\StockResponse;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;
use Throwable;


/**
 * Class StockManagementProvider
 *
 * @package PM\PlentyMarketsBundle\Component\Provider
 */
class StockManagementProvider extends BaseProvider
{
    /**
     * Get All
     *
     * @return Exception|Warehouse[]
     * @throws Throwable
     */
    public function getAll()
    {
        $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::STOCK_MANAGEMENT_WAREHOUSES);
        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), Warehouse::class.'[]', 'json');
    }

    /**
     * Get By Id
     *
     *
     * @return mixed|Exception|Warehouse
     * @throws Throwable
     */
    public function get(int $warehouseId)
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::STOCK_MANAGEMENT_WAREHOUSE, $warehouseId));
        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), Warehouse::class, 'json');
    }

    /**
     *
     * @return Exception|mixed|StockMovement[]
     * @throws Throwable
     */
    public function getMovements(int $warehouseId, ?DateTimeInterface $dateFrom = null, int $page = 1, array $query = [])
    {
        if (null !== $dateFrom) {
            $query['createdAtFrom'] = $dateFrom->format('c');
        }

        $options = [
            'query' => array_merge(
                $query,
                [
                    'itemsPerPage' => 1000,
                    'page'         => $page,
                ]
            ),
        ];

        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::STOCK_MANAGEMENT_WAREHOUSE_STOCK_MOVEMENTS, $warehouseId), $options);
        if ($response instanceof Throwable) {
            return $response;
        }

        $data = $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), StockMovementsResponse::class, 'json');

        if (true === $data->isIsLastPage()) {
            return $data->getEntries();
        }

        /* Get other pages */
        $merged = $this->getMovements($warehouseId, $dateFrom, $page + 1, $query);
        if ($merged instanceof Throwable) {
            return $merged;
        }

        return array_merge($data->getEntries(), $merged);
    }

    /**
     * One page of the stock per storage location, the whole warehouse does not fit in memory.
     */
    public function getStorageLocationStockPage(int $warehouseId, int $page = 1, array $query = []): ItemLocationsResponse|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            sprintf(RestfulUrl::STOCK_MANAGEMENT_WAREHOUSE_STOCK_STORAGE_LOCATIONS, $warehouseId),
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

        return $this->getService()->getSerializer()->deserialize($this->getBodyContentsWithFixedDate($response), ItemLocationsResponse::class, 'json');
    }

    /**
     * One page of the stock movements of a warehouse, for callers that stop early.
     */
    public function getMovementsPage(int $warehouseId, int $page = 1, array $query = []): StockMovementsResponse|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            sprintf(RestfulUrl::STOCK_MANAGEMENT_WAREHOUSE_STOCK_MOVEMENTS, $warehouseId),
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

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), StockMovementsResponse::class, 'json');
    }

    /**
     * One page of the stock per variation and warehouse over all warehouses, filtered for
     * example by variationId (a comma separated list) or updatedAtFrom.
     */
    public function getStockPage(int $page = 1, array $query = []): StockResponse|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::STOCK_MANAGEMENT_STOCK,
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

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), StockResponse::class, 'json');
    }
}
