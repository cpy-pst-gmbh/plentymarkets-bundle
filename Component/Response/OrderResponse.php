<?php


namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Order\Order;

/**
 * Class OrderResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class OrderResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\Order> */
    private array $entries = [];

    /**
     * @return Order[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param Order[] $entries
     *
     * @return OrderResponse
     */
    public function setEntries(array $entries): OrderResponse
    {
        $this->entries = $entries;

        return $this;
    }
}