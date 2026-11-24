<?php

namespace PM\PlentyMarketsBundle\Component\Model\Tag;

use DateTime;

/** A tag as GET tags lists it, with name and colour. */
class Tag
{
    private ?int $id = null;

    private ?string $tagName = null;

    private ?string $color = null;

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

    public function getTagName(): ?string
    {
        return $this->tagName;
    }

    public function setTagName(?string $tagName): static
    {
        $this->tagName = $tagName;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

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
