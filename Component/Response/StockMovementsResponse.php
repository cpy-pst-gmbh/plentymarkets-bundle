<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 09.01.2019
 * Time: 14:55
 */

namespace PM\PlentyMarketsBundle\Component\Response;

use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\StockManagement\StockMovement;

/**
 * Class StockMovementsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
#[JMS\ExclusionPolicy('ALL')]
class StockMovementsResponse extends PaginationResponse
{
    /**
     * @var StockMovement[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\StockManagement\StockMovement>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private array $entries = [];

    /**
     * @return StockMovement[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param StockMovement[] $entries
     *
     * @return StockMovementsResponse
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }
}