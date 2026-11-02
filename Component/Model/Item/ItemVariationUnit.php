<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use JMS\Serializer\Annotation as JMS;

/**
 * Unit and content of a variation, with=unit.
 */
#[JMS\ExclusionPolicy('ALL')]
class ItemVariationUnit
{
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $unitId = null;

    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?float $content = null;

    public function getUnitId(): ?int
    {
        return $this->unitId;
    }

    public function setUnitId(?int $unitId): self
    {
        $this->unitId = $unitId;

        return $this;
    }

    public function getContent(): ?float
    {
        return $this->content;
    }

    public function setContent(?float $content): self
    {
        $this->content = $content;

        return $this;
    }
}
