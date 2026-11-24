<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\StockManagement\Stock;

class StockResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\StockManagement\Stock> */
    private array $entries = [];

    /**
     * @return Stock[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param Stock[] $entries
     */
    public function setEntries(array $entries): self
    {
        $this->entries = $entries;

        return $this;
    }
}
