<?php
/**
 * Created by PhpStorm.
 * Date: 31.08.2017
 * Time: 16:08
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Class ItemVariationStock
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationStock
{
    /** @var int|null */
    private ?int $itemId = null;

    /** @var int|null */
    private ?int $variationId = null;

    /** @var int|null */
    private ?int $warehouseId = null;

    /** @var float|null */
    private ?float $purchasePrice = null;

    /** @var float|null */
    private ?float $reservedListing = null;

    /** @var float|null */
    private ?float $reservedBundles = null;

    /** @var float|null */
    private ?float $physicalStock = null;

    /** @var float|null */
    private ?float $reservedStock = null;

    /** @var float|null */
    private ?float $netStock = null;

    /** @var float|null */
    private ?float $reorderLevel = null;

    /** @var float|null */
    private ?float $deltaReorderLevel = null;

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     *
     * @return ItemVariationStock
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * @return int
     */
    public function getVariationId()
    {
        return $this->variationId;
    }

    /**
     * @param int $variationId
     *
     * @return ItemVariationStock
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getWarehouseId()
    {
        return $this->warehouseId;
    }

    /**
     * @param int $warehouseId
     *
     * @return ItemVariationStock
     */
    public function setWarehouseId($warehouseId)
    {
        $this->warehouseId = $warehouseId;

        return $this;
    }

    /**
     * @return float
     */
    public function getPurchasePrice()
    {
        return $this->purchasePrice;
    }

    /**
     * @param float $purchasePrice
     *
     * @return ItemVariationStock
     */
    public function setPurchasePrice($purchasePrice)
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    /**
     * @return float
     */
    public function getReservedListing()
    {
        return $this->reservedListing;
    }

    /**
     * @param float $reservedListing
     *
     * @return ItemVariationStock
     */
    public function setReservedListing($reservedListing)
    {
        $this->reservedListing = $reservedListing;

        return $this;
    }

    /**
     * @return float
     */
    public function getReservedBundles()
    {
        return $this->reservedBundles;
    }

    /**
     * @param float $reservedBundles
     *
     * @return ItemVariationStock
     */
    public function setReservedBundles($reservedBundles)
    {
        $this->reservedBundles = $reservedBundles;

        return $this;
    }

    /**
     * @return float
     */
    public function getPhysicalStock()
    {
        return $this->physicalStock;
    }

    /**
     * @param float $physicalStock
     *
     * @return ItemVariationStock
     */
    public function setPhysicalStock($physicalStock)
    {
        $this->physicalStock = $physicalStock;

        return $this;
    }

    /**
     * @return float
     */
    public function getReservedStock()
    {
        return $this->reservedStock;
    }

    /**
     * @param float $reservedStock
     *
     * @return ItemVariationStock
     */
    public function setReservedStock($reservedStock)
    {
        $this->reservedStock = $reservedStock;

        return $this;
    }

    /**
     * @return float
     */
    public function getNetStock()
    {
        return $this->netStock;
    }

    /**
     * @param float $netStock
     *
     * @return ItemVariationStock
     */
    public function setNetStock($netStock)
    {
        $this->netStock = $netStock;

        return $this;
    }

    /**
     * @return float
     */
    public function getReorderLevel()
    {
        return $this->reorderLevel;
    }

    /**
     * @param float $reorderLevel
     *
     * @return ItemVariationStock
     */
    public function setReorderLevel($reorderLevel)
    {
        $this->reorderLevel = $reorderLevel;

        return $this;
    }

    /**
     * @return float
     */
    public function getDeltaReorderLevel()
    {
        return $this->deltaReorderLevel;
    }

    /**
     * @param float $deltaReorderLevel
     *
     * @return ItemVariationStock
     */
    public function setDeltaReorderLevel($deltaReorderLevel)
    {
        $this->deltaReorderLevel = $deltaReorderLevel;

        return $this;
    }

}