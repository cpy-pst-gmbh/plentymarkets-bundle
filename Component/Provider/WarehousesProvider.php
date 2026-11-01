<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 19.11.2018
 * Time: 09:58
 */

namespace PM\PlentyMarketsBundle\Component\Provider;


use Exception;
use PM\PlentyMarketsBundle\Component\Model\Warehouses\Dimension;
use PM\PlentyMarketsBundle\Component\Model\Warehouses\Level;
use PM\PlentyMarketsBundle\Component\Model\Warehouses\Location;
use PM\PlentyMarketsBundle\Component\Response\LocationsResponse;
use PM\PlentyMarketsBundle\Component\Response\LocationStockResponse;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

/**
 * Class WarehousesProvider
 *
 * @package PM\PlentyMarketsBundle\Component\Provider
 */
class WarehousesProvider extends BaseProvider
{
    /**
     * Get location stock
     *
     * @param int $locationId
     * @param int $page
     *
     * @return object|Exception|LocationStockResponse
     */
    public function getLocationStock($locationId, $page = 1)
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            sprintf(RestfulUrl::WAREHOUSES_LOCATIONS_STOCK, $locationId),
            [
                'query' => [
                    'page' => $page,
                ],
            ]
        );

        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), LocationStockResponse::class, 'json');
    }

    /**
     * Get Location
     *
     *
     * @return Throwable|Location|object
     * @throws Throwable
     */
    public function getLocation(int $warehouseLocationId)
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::WAREHOUSES_LOCATIONS_LOCATION, $warehouseLocationId));

        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), Location::class, 'json');
    }

    /**
     * Get Locations
     *
     * @param int      $warehouseId
     * @param int      $page
     * @param int|null $levelId
     *
     * @return object|Exception|LocationsResponse
     * @throws Throwable
     */
    public function getLocations($warehouseId, $page = 1, ?int $levelId = null)
    {
        $query = [
            'page'         => $page,
            'itemsPerPage' => 100,
        ];

        if (null !== $levelId) {
            $query['levelId'] = $levelId;
        }

        $response = $this->getResponse(
            Request::METHOD_GET,
            sprintf(RestfulUrl::WAREHOUSES_LOCATIONS, $warehouseId),
            [
                'query' => $query,
            ]
        );

        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), LocationsResponse::class, 'json');
    }

    /**
     * Get Dimensions
     *
     * @param int $warehouseId
     *
     * @return array|Exception|Dimension[]
     * @throws Throwable
     */
    public function getDimensions($warehouseId)
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::WAREHOUSES_LOCATIONS_DIMENSIONS, $warehouseId));
        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), sprintf('array<%s>', Dimension::class), 'json');
    }

    /**
     * Get Levels
     *
     * @param int $warehouseId
     *
     * @return array|Exception|Level[]
     * @throws Throwable
     */
    public function getLevels($warehouseId)
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::WAREHOUSES_LOCATIONS_LEVELS, $warehouseId));
        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), sprintf('array<%s>', Level::class), 'json');
    }

}