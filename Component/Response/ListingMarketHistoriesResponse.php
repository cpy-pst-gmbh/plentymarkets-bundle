<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Listing\ListingMarketHistory;

class ListingMarketHistoriesResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Listing\ListingMarketHistory> */
    private array $entries = [];

    /**
     * @return ListingMarketHistory[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param ListingMarketHistory[] $entries
     */
    public function setEntries(array $entries): self
    {
        $this->entries = $entries;

        return $this;
    }
}
