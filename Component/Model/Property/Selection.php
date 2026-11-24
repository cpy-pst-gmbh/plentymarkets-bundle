<?php

namespace PM\PlentyMarketsBundle\Component\Model\Property;

use DateTime;

/** A value of a selection property; its names are the values of its relation. */
class Selection
{
    private ?int $id = null;

    private ?int $propertyId = null;

    private ?int $position = null;

    private ?DateTime $createdAt = null;

    private ?DateTime $updatedAt = null;

    private ?Relation $relation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getPropertyId(): ?int
    {
        return $this->propertyId;
    }

    public function setPropertyId(?int $propertyId): static
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRelation(): ?Relation
    {
        return $this->relation;
    }

    public function setRelation(?Relation $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    /** The name in the language, null without one. */
    public function getName(string $lang): ?string
    {
        foreach ($this->relation?->getRelationValues() ?? [] as $value) {
            if ($lang === $value->getLang()) {
                return $value->getValue();
            }
        }

        return null;
    }
}
