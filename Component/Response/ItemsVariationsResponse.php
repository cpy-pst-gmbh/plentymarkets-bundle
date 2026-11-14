<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Item\ItemVariation;

class ItemsVariationsResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariation> */
    private array $entries = [];

    /**
     * @return ItemVariation[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param ItemVariation[] $entries
     *
     * @return ItemsVariationsResponse
     */
    public function setEntries(array $entries): static
    {
        $this->entries = $entries;

        return $this;
    }

}
