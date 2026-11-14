<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 09.01.2019
 * Time: 14:55
 */

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\StockManagement\StockMovement;

/**
 * Class StockMovementsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class StockMovementsResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\StockManagement\StockMovement> */
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