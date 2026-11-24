<?php

namespace PM\PlentyMarketsBundle\Component\Model\Tag;

use DateTime;

/** A tag on a record as GET tags/relationships lists it: id is the relationship, relationshipValue the record. */
class TagRelationship
{
    private ?int $id = null;

    private ?int $tagId = null;

    private ?string $tagType = null;

    private ?int $relationshipValue = null;

    private ?string $relationshipUUID5 = null;

    private ?DateTime $createdAt = null;

    private ?DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTagId(): ?int
    {
        return $this->tagId;
    }

    public function setTagId(?int $tagId): static
    {
        $this->tagId = $tagId;

        return $this;
    }

    public function getTagType(): ?string
    {
        return $this->tagType;
    }

    public function setTagType(?string $tagType): static
    {
        $this->tagType = $tagType;

        return $this;
    }

    public function getRelationshipValue(): ?int
    {
        return $this->relationshipValue;
    }

    public function setRelationshipValue(?int $relationshipValue): static
    {
        $this->relationshipValue = $relationshipValue;

        return $this;
    }

    public function getRelationshipUUID5(): ?string
    {
        return $this->relationshipUUID5;
    }

    public function setRelationshipUUID5(?string $relationshipUUID5): static
    {
        $this->relationshipUUID5 = $relationshipUUID5;

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
}
