<?php

namespace PM\PlentyMarketsBundle\Component\Model\Property;


class Property
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $propertyId = null;

    /** @var string */
    private string $cast = '';

    /** @var string */
    private string $typeIdentifier = '';

    /** @var int|null */
    private ?int $propertyGroupId = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Property\PropertyName> */
    private array $names = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Property
    {
        $this->id = $id;

        return $this;
    }

    public function getPropertyId(): ?int
    {
        return $this->propertyId;
    }

    public function setPropertyId(?int $propertyId): Property
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    public function getCast(): string
    {
        return $this->cast;
    }

    public function setCast(string $cast): Property
    {
        $this->cast = $cast;

        return $this;
    }

    public function getTypeIdentifier(): string
    {
        return $this->typeIdentifier;
    }

    public function setTypeIdentifier(string $typeIdentifier): Property
    {
        $this->typeIdentifier = $typeIdentifier;

        return $this;
    }

    public function getPropertyGroupId(): ?int
    {
        return $this->propertyGroupId;
    }

    public function setPropertyGroupId(?int $propertyGroupId): Property
    {
        $this->propertyGroupId = $propertyGroupId;

        return $this;
    }

    public function getNames(): array
    {
        return $this->names;
    }

    public function setNames(array $names): Property
    {
        $this->names = $names;

        return $this;
    }

}
