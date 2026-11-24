<?php

namespace PM\PlentyMarketsBundle\Component\Model\StockManagement;

use DateTime;
use Symfony\Component\Serializer\Attribute\SerializedName;

/** The stock of a variation in one warehouse, as GET stockmanagement/stock lists it. */
class Stock
{
    private ?int $itemId = null;

    private ?int $variationId = null;

    private ?int $warehouseId = null;

    private ?float $stockPhysical = null;

    private ?float $reservedStock = null;

    private ?float $reservedEbay = null;

    private ?float $reorderDelta = null;

    private ?float $stockNet = null;

    private ?float $reordered = null;

    private ?float $reservedBundle = null;

    private ?float $averagePurchasePrice = null;

    #[SerializedName('storehouse_type')]
    private ?int $storehouseType = null;

    private ?int $warehousePriority = null;

    private ?DateTime $updatedAt = null;

    public function getItemId(): ?int
    {
        return $this->itemId;
    }

    public function setItemId(?int $itemId): static
    {
        $this->itemId = $itemId;

        return $this;
    }

    public function getVariationId(): ?int
    {
        return $this->variationId;
    }

    public function setVariationId(?int $variationId): static
    {
        $this->variationId = $variationId;

        return $this;
    }

    public function getWarehouseId(): ?int
    {
        return $this->warehouseId;
    }

    public function setWarehouseId(?int $warehouseId): static
    {
        $this->warehouseId = $warehouseId;

        return $this;
    }

    public function getStockPhysical(): ?float
    {
        return $this->stockPhysical;
    }

    public function setStockPhysical(?float $stockPhysical): static
    {
        $this->stockPhysical = $stockPhysical;

        return $this;
    }

    public function getReservedStock(): ?float
    {
        return $this->reservedStock;
    }

    public function setReservedStock(?float $reservedStock): static
    {
        $this->reservedStock = $reservedStock;

        return $this;
    }

    public function getReservedEbay(): ?float
    {
        return $this->reservedEbay;
    }

    public function setReservedEbay(?float $reservedEbay): static
    {
        $this->reservedEbay = $reservedEbay;

        return $this;
    }

    public function getReorderDelta(): ?float
    {
        return $this->reorderDelta;
    }

    public function setReorderDelta(?float $reorderDelta): static
    {
        $this->reorderDelta = $reorderDelta;

        return $this;
    }

    public function getStockNet(): ?float
    {
        return $this->stockNet;
    }

    public function setStockNet(?float $stockNet): static
    {
        $this->stockNet = $stockNet;

        return $this;
    }

    public function getReordered(): ?float
    {
        return $this->reordered;
    }

    public function setReordered(?float $reordered): static
    {
        $this->reordered = $reordered;

        return $this;
    }

    public function getReservedBundle(): ?float
    {
        return $this->reservedBundle;
    }

    public function setReservedBundle(?float $reservedBundle): static
    {
        $this->reservedBundle = $reservedBundle;

        return $this;
    }

    public function getAveragePurchasePrice(): ?float
    {
        return $this->averagePurchasePrice;
    }

    public function setAveragePurchasePrice(?float $averagePurchasePrice): static
    {
        $this->averagePurchasePrice = $averagePurchasePrice;

        return $this;
    }

    public function getStorehouseType(): ?int
    {
        return $this->storehouseType;
    }

    public function setStorehouseType(?int $storehouseType): static
    {
        $this->storehouseType = $storehouseType;

        return $this;
    }

    public function getWarehousePriority(): ?int
    {
        return $this->warehousePriority;
    }

    public function setWarehousePriority(?int $warehousePriority): static
    {
        $this->warehousePriority = $warehousePriority;

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
