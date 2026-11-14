<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Listing\ListingMarket;

class ListingMarketsResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Listing\ListingMarket> */
    private array $entries = [];

    /**
     * @return ListingMarket[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param ListingMarket[] $entries
     */
    public function setEntries(array $entries): self
    {
        $this->entries = $entries;

        return $this;
    }
}
