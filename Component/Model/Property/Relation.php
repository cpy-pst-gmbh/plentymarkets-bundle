<?php

namespace PM\PlentyMarketsBundle\Component\Model\Property;

use DateTime;

class Relation
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $propertyId = null;

    /** @var string */
    private string $relationTypeIdentifier = '';

    /** @var int|null */
    private ?int $relationTargetId = null;

    /** @var int|null */
    private ?int $selectionRelationId = null;

    /** @var int|null */
    private ?int $groupId = null;

    /** @var int|null */
    private ?int $markup = null;

    /** @var \DateTime|null */
    private ?DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?DateTime $updatedAt = null;

    /** @var \PM\PlentyMarketsBundle\Component\Model\Property\Property|null */
    private ?Property $property = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Property\RelationValue> */
    private array $relationValues = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Relation
    {
        $this->id = $id;

        return $this;
    }

    public function getPropertyId(): ?int
    {
        return $this->propertyId;
    }

    public function setPropertyId(?int $propertyId): Relation
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    public function getRelationTypeIdentifier(): string
    {
        return $this->relationTypeIdentifier;
    }

    public function setRelationTypeIdentifier(string $relationTypeIdentifier): Relation
    {
        $this->relationTypeIdentifier = $relationTypeIdentifier;

        return $this;
    }

    public function getRelationTargetId(): ?int
    {
        return $this->relationTargetId;
    }

    public function setRelationTargetId(?int $relationTargetId): Relation
    {
        $this->relationTargetId = $relationTargetId;

        return $this;
    }

    public function getSelectionRelationId(): ?int
    {
        return $this->selectionRelationId;
    }

    public function setSelectionRelationId(?int $selectionRelationId): Relation
    {
        $this->selectionRelationId = $selectionRelationId;

        return $this;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroupId(?int $groupId): Relation
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getMarkup(): ?int
    {
        return $this->markup;
    }

    public function setMarkup(?int $markup): Relation
    {
        $this->markup = $markup;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): Relation
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): Relation
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): Relation
    {
        $this->property = $property;

        return $this;
    }

    public function getRelationValues(): array
    {
        return $this->relationValues;
    }

    public function setRelationValues(array $relationValues): Relation
    {
        $this->relationValues = $relationValues;

        return $this;
    }

}
