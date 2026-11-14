<?php

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use DateTimeInterface;

class OrderItem
{
    const TYPE_VARIATION = 1;
    const TYPE_BUNDLE = 2;
    const TYPE_BUNDLE_COMPONENT = 3;
    const TYPE_PROMOTIONAL_COUPON = 4;
    const TYPE_GIFT_CARD = 5;
    const TYPE_SHIPPING_COST = 6;
    const TYPE_PAYMENT_SURCHARGE = 7;
    const TYPE_GIFT_WRAP = 8;
    const TYPE_UNASSIGNED_VARIATION = 9;
    const TYPE_DEPOSIT = 10;
    const TYPE_ORDER = 11;

    /** @var int */
    private readonly int $id;

    /** @var int */
    private readonly int $orderId;

    /** @var int|null */
    private ?int $typeId = null;

    /* Herkuenfte haben Nachkommastellen, 4.01 ist Amazon Deutschland. */
    /** @var float|null */
    private ?float $referrerId = null;

    /** @var int|null */
    private ?int $itemVariationId = null;

    /** @var int|null */
    private ?int $quantity = null;

    /** @var string|null */
    private ?string $orderItemName = null;

    /** @var string|null */
    private ?string $attributeValues = null;

    /** @var int|null */
    private ?int $shippingProfileId = null;

    /** @var int|null */
    private ?int $vatField = null;

    /** @var int|null */
    private ?int $vatRate = null;

    /** @var \DateTime|null */
    private ?DateTimeInterface $createdAt = null;

    /** @var \DateTime|null */
    private ?DateTimeInterface $updatedAt = null;

    /** @var int|null */
    private ?int $warehouseId = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderItemAmount> */
    private array $amounts = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderItemProperty> */
    private array $properties = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderItemReference> */
    private array $references = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderItemWarehouseLocation> */
    private array $warehouseLocations = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    public function getReferrerId(): ?float
    {
        return $this->referrerId;
    }

    public function getItemVariationId(): ?int
    {
        return $this->itemVariationId;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function getOrderItemName(): ?string
    {
        return $this->orderItemName;
    }

    public function getAttributeValues(): ?string
    {
        return $this->attributeValues;
    }

    public function getShippingProfileId(): ?int
    {
        return $this->shippingProfileId;
    }

    public function getVatField(): ?int
    {
        return $this->vatField;
    }

    public function getVatRate(): ?int
    {
        return $this->vatRate;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getWarehouseId(): ?int
    {
        return $this->warehouseId;
    }

    public function getAmounts(): array
    {
        return $this->amounts;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getReferences(): array
    {
        return $this->references;
    }

    public function getWarehouseLocations(): array
    {
        return $this->warehouseLocations;
    }

    public function getAmountByCurrency(string $currency): ?OrderItemAmount
    {
        foreach ($this->getAmounts() as $amount) {
            if ($currency === $amount->getCurrency()) {
                return $amount;
            }
        }

        return null;
    }

    public function getPropertyByTypeId($typeId): ?OrderItemProperty
    {
        foreach ($this->getProperties() as $property) {
            if ($typeId === $property->getTypeId()) {
                return $property;
            }
        }

        return null;
    }
}