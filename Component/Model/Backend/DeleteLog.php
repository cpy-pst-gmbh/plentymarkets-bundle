<?php

namespace PM\PlentyMarketsBundle\Component\Model\Backend;

/**
 * Entry of the delete log: which record was deleted, when and by whom. UpdatedAt stays a
 * string, plenty sends local time without zone ("2026-10-31 11:56:36").
 */
class DeleteLog
{
    public const REFERENCE_TYPE_CATEGORY = 1;
    public const REFERENCE_TYPE_PAYMENT = 2;
    public const REFERENCE_TYPE_ORDER = 3;
    public const REFERENCE_TYPE_CUSTOMER = 4;
    public const REFERENCE_TYPE_ITEM = 5;
    public const REFERENCE_TYPE_VARIATION = 13;

    /** @var int|null */
    private ?int $referenceType = null;

    /** @var int|null */
    private ?int $referenceValue = null;

    /** @var string|null */
    private ?string $updatedAt = null;

    /** @var int|null */
    private ?int $userId = null;

    /** @var string|null */
    private ?string $userRealName = null;

    public function getReferenceType(): ?int
    {
        return $this->referenceType;
    }

    public function setReferenceType(?int $referenceType): self
    {
        $this->referenceType = $referenceType;

        return $this;
    }

    /**
     * The ID of the deleted record.
     */
    public function getReferenceValue(): ?int
    {
        return $this->referenceValue;
    }

    public function setReferenceValue(?int $referenceValue): self
    {
        $this->referenceValue = $referenceValue;

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * 0 for a deletion without backend user, the name is still set then.
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserRealName(): ?string
    {
        return $this->userRealName;
    }

    public function setUserRealName(?string $userRealName): self
    {
        $this->userRealName = $userRealName;

        return $this;
    }
}
