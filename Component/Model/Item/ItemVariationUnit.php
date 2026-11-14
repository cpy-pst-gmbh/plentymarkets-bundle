<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Unit and content of a variation, with=unit.
 */
class ItemVariationUnit
{
    /**
     * Id of the combination of unit and content.
     * @var int|null
     */
    private ?int $id = null;

    /** @var int|null */
    private ?int $unitId = null;

    /** @var float|null */
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
