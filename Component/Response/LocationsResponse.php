<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 21.11.2018
 * Time: 11:04
 */

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Warehouses\Location;

/**
 * Class LocationsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class LocationsResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Warehouses\Location> */
    private array $entries = [];

    /**
     * @return Location[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param Location[] $entries
     *
     * @return LocationsResponse
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

}