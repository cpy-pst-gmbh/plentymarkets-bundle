<?php

namespace PM\PlentyMarketsBundle\Component\Model\Mixed;

use DateTime;

class Tag
{
    /** @var int|null */
    private ?int $id = null;

    /** @var string */
    private string $tagName = '';

    /** @var string */
    private string $color = '';

    /** @var \DateTime|null */
    private ?DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Tag
    {
        $this->id = $id;

        return $this;
    }

    public function getTagName(): string
    {
        return $this->tagName;
    }

    public function setTagName(string $tagName): Tag
    {
        $this->tagName = $tagName;

        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): Tag
    {
        $this->color = $color;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}