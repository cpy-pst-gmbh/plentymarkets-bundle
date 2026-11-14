<?php


namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Warehouses\LocationStock;
use JMS\Serializer\Annotation as JMS;

/**
 * Class LocationStockResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class LocationStockResponse extends PaginationResponse
{

    /**
     * @var LocationStock[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Warehouses\LocationStock>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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