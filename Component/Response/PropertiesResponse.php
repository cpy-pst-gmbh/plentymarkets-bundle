<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use AppBundle\Entity\Property\Property;

class PropertiesResponse extends PaginationResponse
{

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Property\Property> */
    private array $entries = [];

    /**
     * @return Property[]
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
