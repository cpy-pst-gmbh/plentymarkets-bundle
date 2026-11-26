<?php

namespace PM\PlentyMarketsBundle\Component\Model\Payment;

/**
 * Payment in plentymarkets (GET/POST payments). Dates stay strings, as plenty sends them.
 */
class Payment
{
    public const STATUS_AWAITING_APPROVAL = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_CAPTURED = 3;

    public const TRANSACTION_TYPE_INTERIM = 1;
    public const TRANSACTION_TYPE_BOOKED = 2;

    public const ORIGIN_MANUALLY = 2;
    public const ORIGIN_IMPORT = 4;

    /** @var int|null */
    private ?int $id = null;

    /** @var float|null */
    private ?float $amount = null;

    /** @var float|null */
    private ?float $exchangeRatio = null;

    /** @var int|null */
    private ?int $parentId = null;

    /** @var int|null */
    private ?int $deleted = null;

    /** @var int|null */
    private ?int $unaccountable = null;

    /** @var string|null */
    private ?string $currency = null;

    /** @var string|null */
    private ?string $type = null;

    /** @var string|null */
    private ?string $hash = null;

    /** @var int|null */
    private ?int $origin = null;

    /** @var string|null */
    private ?string $receivedAt = null;

    /** @var string|null */
    private ?string $importedAt = null;

    /** @var int|null */
    private ?int $status = null;

    /** @var int|null */
    private ?int $transactionType = null;

    /** @var int|null */
    private ?int $mopId = null;

    /** @var bool|null */
    private ?bool $isSystemCurrency = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Payment\PaymentProperty> */
    private array $properties = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getExchangeRatio(): ?float
    {
        return $this->exchangeRatio;
    }

    public function setExchangeRatio(?float $exchangeRatio): self
    {
        $this->exchangeRatio = $exchangeRatio;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * 1 for a deleted payment
     */
    public function getDeleted(): ?int
    {
        return $this->deleted;
    }

    public function setDeleted(?int $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * 1 for an unassigned payment
     */
    public function getUnaccountable(): ?int
    {
        return $this->unaccountable;
    }

    public function setUnaccountable(?int $unaccountable): self
    {
        $this->unaccountable = $unaccountable;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * credit or debit
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(?string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Payment::ORIGIN_*
     */
    public function getOrigin(): ?int
    {
        return $this->origin;
    }

    public function setOrigin(?int $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * ISO 8601 as plenty sends it
     */
    public function getReceivedAt(): ?string
    {
        return $this->receivedAt;
    }

    public function setReceivedAt(?string $receivedAt): self
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    public function getImportedAt(): ?string
    {
        return $this->importedAt;
    }

    public function setImportedAt(?string $importedAt): self
    {
        $this->importedAt = $importedAt;

        return $this;
    }

    /**
     * Payment::STATUS_*
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Payment::TRANSACTION_TYPE_*
     */
    public function getTransactionType(): ?int
    {
        return $this->transactionType;
    }

    public function setTransactionType(?int $transactionType): self
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * ID of the payment method
     */
    public function getMopId(): ?int
    {
        return $this->mopId;
    }

    public function setMopId(?int $mopId): self
    {
        $this->mopId = $mopId;

        return $this;
    }

    public function isIsSystemCurrency(): ?bool
    {
        return $this->isSystemCurrency;
    }

    public function setIsSystemCurrency(?bool $isSystemCurrency): self
    {
        $this->isSystemCurrency = $isSystemCurrency;

        return $this;
    }

    /**
     * @return PaymentProperty[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param PaymentProperty[] $properties
     */
    public function setProperties(array $properties): self
    {
        $this->properties = $properties;

        return $this;
    }

    public function getPropertyValue(int $typeId): ?string
    {
        foreach ($this->properties as $property) {
            if ($typeId === $property->getTypeId()) {
                return $property->getValue();
            }
        }

        return null;
    }
}
