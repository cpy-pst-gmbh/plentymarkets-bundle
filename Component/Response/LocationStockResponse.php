<?php


namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Warehouses\LocationStock;

/**
 * Class LocationStockResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class LocationStockResponse extends PaginationResponse
{

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Warehouses\LocationStock> */
    private array $entries = [];

    /**
     * @return LocationStock[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param LocationStock[] $entries
     *
     * @return LocationStockResponse
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

}