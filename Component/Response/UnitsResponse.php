<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\Item\Unit;

#[JMS\ExclusionPolicy('ALL')]
class UnitsResponse extends PaginationResponse
{
    /**
     * @var Unit[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Item\Unit>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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
