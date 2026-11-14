<?php

namespace PM\PlentyMarketsBundle\Component\Model\Property;

use DateTime;

use function PHPUnit\Framework\isEmpty;

class RelationValue
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $propertyRelationId = null;

    /** @var string|null */
    private ?string $lang = null;

    /** @var string|null */
    private ?string $value = null;

    /** @var string|null */
    private ?string $description = null;

    /** @var \DateTime|null */
    private ?DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): RelationValue
    {
        $this->id = $id;

        return $this;
    }

    public function getPropertyRelationId(): ?int
    {
        return $this->propertyRelationId;
    }

    public function setPropertyRelationId(?int $propertyRelationId): RelationValue
    {
        $this->propertyRelationId = $propertyRelationId;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(?string $lang): RelationValue
    {
        $this->lang = $lang;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): RelationValue
    {
        $this->value = $value;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): RelationValue
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): RelationValue
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): RelationValue
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
