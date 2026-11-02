<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use JMS\Serializer\Annotation as JMS;

/**
 * Unit and content of a variation, with=unit.
 */
#[JMS\ExclusionPolicy('ALL')]
class ItemVariationUnit
{
    /**
     * Id of the combination of unit and content.
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $id = null;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $unitId = null;

    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?float $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

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
