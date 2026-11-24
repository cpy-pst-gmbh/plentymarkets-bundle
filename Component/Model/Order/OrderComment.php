<?php

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use DateTime;

/** A comment on an order, read with with[]=comments. */
class OrderComment
{
    private ?int $id = null;

    private ?string $referenceType = null;

    private ?int $referenceValue = null;

    private ?int $userId = null;

    private ?string $text = null;

    private ?bool $isVisibleForContact = null;

    private ?DateTime $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getReferenceType(): ?string
    {
        return $this->referenceType;
    }

    public function setReferenceType(?string $referenceType): static
    {
        $this->referenceType = $referenceType;

        return $this;
    }

    public function getReferenceValue(): ?int
    {
        return $this->referenceValue;
    }

    public function setReferenceValue(?int $referenceValue): static
    {
        $this->referenceValue = $referenceValue;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function isVisibleForContact(): ?bool
    {
        return $this->isVisibleForContact;
    }

    public function setIsVisibleForContact(?bool $isVisibleForContact): static
    {
        $this->isVisibleForContact = $isVisibleForContact;

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
}
