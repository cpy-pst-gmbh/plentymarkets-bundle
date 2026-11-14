<?php

namespace PM\PlentyMarketsBundle\Component\Model\Property;

use DateTime;

class PropertyName
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $propertyId = null;

    /** @var string */
    private string $lang = '';

    /** @var string */
    private string $name = '';

    /** @var string */
    private string $description = '';

    /** @var \DateTime|null */
    private ?DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): PropertyName
    {
        $this->id = $id;

        return $this;
    }

    public function getPropertyId(): ?int
    {
        return $this->propertyId;
    }

    public function setPropertyId(?int $propertyId): PropertyName
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function setLang(string $lang): PropertyName
    {
        $this->lang = $lang;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): PropertyName
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): PropertyName
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): PropertyName
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): PropertyName
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
