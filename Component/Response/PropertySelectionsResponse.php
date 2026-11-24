<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Property\Selection;

class PropertySelectionsResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Property\Selection> */
    private array $entries = [];

    /**
     * @return list<Selection>
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    public function setEntries(array $entries): static
    {
        $this->entries = $entries;

        return $this;
    }
}
