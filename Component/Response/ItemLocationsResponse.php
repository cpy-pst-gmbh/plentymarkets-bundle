<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 23.11.2018
 * Time: 16:41
 */

namespace PM\PlentyMarketsBundle\Component\Response;


use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationStockStorageLocation;

/**
 * Class ItemLocationsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class ItemLocationsResponse extends PaginationResponse
{
    /**
     * @var ItemVariationStockStorageLocation[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationStockStorageLocation>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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