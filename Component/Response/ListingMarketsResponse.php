<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\Listing\ListingMarket;

#[JMS\ExclusionPolicy('ALL')]
class ListingMarketsResponse extends PaginationResponse
{
    /**
     * @var ListingMarket[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Listing\ListingMarket>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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
