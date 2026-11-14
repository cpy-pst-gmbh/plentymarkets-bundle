<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 23.11.2018
 * Time: 16:41
 */

namespace PM\PlentyMarketsBundle\Component\Response;


use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationStockStorageLocation;

/**
 * Class ItemLocationsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class ItemLocationsResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationStockStorageLocation> */
    private array $entries = [];

    /**
     * @return ItemVariationStockStorageLocation[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param ItemVariationStockStorageLocation[] $entries
     *
     * @return ItemLocationsResponse
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }
}