<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Item\Unit;

class UnitsResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\Unit> */
    private array $entries = [];

    /**
     * @return Unit[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param Unit[] $entries
     */
    public function setEntries(array $entries): self
    {
        $this->entries = $entries;

        return $this;
    }
}
