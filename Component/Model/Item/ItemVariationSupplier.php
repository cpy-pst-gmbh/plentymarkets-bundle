<?php


namespace PM\PlentyMarketsBundle\Component\Model\Item;


class ItemVariationSupplier
{
    /** @var int */
    private int $id;

    /** @var int|null */
    private ?int $variationId = null;

    /** @var int|null */
    private ?int $supplierId = null;

    /** @var float|null */
    private ?float $purchasePrice = null;

    /** @var int|null */
    private ?int $minimumPurchase = null;

    /** @var string|null */
    private ?string $itemNumber = null;

    /** @var string|null */
    private ?string $lastPriceQuery = null;

    /** @var int|null */
    private ?int $deliveryTimeInDays = null;

    /** @var float|null */
    private ?float $discount = null;

    /** @var bool|null */
    private ?bool $isDiscountable = null;

    /** @var int|null */
    private ?int $packagingUnit = null;

    /** @var \DateTime|null */
    private ?\DateTime $lastUpdateTimestamp = null;

    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setId(int $id): ItemVariationSupplier
    {
        $this->id = $id;

        return $this;
    }

    public function getVariationId(): int
    {
        return $this->variationId;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setVariationId(int $variationId): ItemVariationSupplier
    {
        $this->variationId = $variationId;

        return $this;
    }

    public function getSupplierId(): int
    {
        return $this->supplierId;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setSupplierId(int $supplierId): ItemVariationSupplier
    {
        $this->supplierId = $supplierId;

        return $this;
    }

    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setPurchasePrice(float $purchasePrice): ItemVariationSupplier
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getMinimumPurchase(): ?int
    {
        return $this->minimumPurchase;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setMinimumPurchase(int $minimumPurchase): ItemVariationSupplier
    {
        $this->minimumPurchase = $minimumPurchase;

        return $this;
    }

    public function getItemNumber(): ?string
    {
        return $this->itemNumber;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setItemNumber(string $itemNumber): ItemVariationSupplier
    {
        $this->itemNumber = $itemNumber;

        return $this;
    }

    public function getLastPriceQuery(): ?string
    {
        return $this->lastPriceQuery;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setLastPriceQuery(string $lastPriceQuery): ItemVariationSupplier
    {
        $this->lastPriceQuery = $lastPriceQuery;

        return $this;
    }

    public function getDeliveryTimeInDays(): ?int
    {
        return $this->deliveryTimeInDays;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setDeliveryTimeInDays(int $deliveryTimeInDays): ItemVariationSupplier
    {
        $this->deliveryTimeInDays = $deliveryTimeInDays;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setDiscount(float $discount): ItemVariationSupplier
    {
        $this->discount = $discount;

        return $this;
    }

    public function isDiscountable(): ?bool
    {
        return $this->isDiscountable;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setIsDiscountable(bool $isDiscountable): ItemVariationSupplier
    {
        $this->isDiscountable = $isDiscountable;

        return $this;
    }

    public function getPackagingUnit(): ?int
    {
        return $this->packagingUnit;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setPackagingUnit(int $packagingUnit): ItemVariationSupplier
    {
        $this->packagingUnit = $packagingUnit;

        return $this;
    }

    public function getLastUpdateTimestamp(): ?\DateTime
    {
        return $this->lastUpdateTimestamp;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setLastUpdateTimestamp(\DateTime $lastUpdateTimestamp): ItemVariationSupplier
    {
        $this->lastUpdateTimestamp = $lastUpdateTimestamp;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return ItemVariationSupplier
     */
    public function setCreatedAt(\DateTime $createdAt): ItemVariationSupplier
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}