<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Unit of measurement such as C62 (piece) or KGM (kilogram), items/units.
 */
class Unit
{
    /** @var int|null */
    private ?int $id = null;

    /** @var string|null */
    private ?string $unitOfMeasurement = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\UnitName> */
    private array $names = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUnitOfMeasurement(): ?string
    {
        return $this->unitOfMeasurement;
    }

    public function setUnitOfMeasurement(?string $unitOfMeasurement): self
    {
        $this->unitOfMeasurement = $unitOfMeasurement;

        return $this;
    }

    /**
     * @return UnitName[]
     */
    public function getNames(): array
    {
        return $this->names;
    }

    /**
     * @param UnitName[] $names
     */
    public function setNames(array $names): self
    {
        $this->names = $names;

        return $this;
    }

    public function getNameByLang(string $lang): ?string
    {
        foreach ($this->names as $name) {
            if ($lang === $name->getLang()) {
                return $name->getName();
            }
        }

        return null;
    }
}
