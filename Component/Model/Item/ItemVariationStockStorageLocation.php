<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 26.11.2018
 * Time: 10:55
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;

/**
 * Class ItemVariationStockStorageLocation
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationStockStorageLocation
{
    /** @var int|null */
    private ?int $storageLocationId = null;

    /** @var int|null */
    private ?int $itemId = null;

    /** @var int|null */
    private ?int $warehouseId = null;

    /** @var int|null */
    private ?int $quantity = null;

    /** @var int|null */
    private ?int $variationId = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

    /** @var string|null */
    private ?string $batch = null;

    /** @var string|null */
    private ?string $bestBeforeDate = null;

    /**
     * @return int
     */
    public function getStorageLocationId()
    {
        return $this->storageLocationId;
    }

    /**
     * @param int $storageLocationId
     *
     * @return ItemVariationStockStorageLocation
     */
    public function setStorageLocationId($storageLocationId)
    {
        $this->storageLocationId = $storageLocationId;

        return $this;
    }

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
     * @return ItemVariationStockStorageLocation
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

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
     * @return ItemVariationStockStorageLocation
     */
    public function setWarehouseId($warehouseId)
    {
        $this->warehouseId = $warehouseId;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return ItemVariationStockStorageLocation
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

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
     * @return ItemVariationStockStorageLocation
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     *
     * @return ItemVariationStockStorageLocation
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * @param string $batch
     *
     * @return ItemVariationStockStorageLocation
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;

        return $this;
    }

    /**
     * @return string
     */
    public function getBestBeforeDate()
    {
        return $this->bestBeforeDate;
    }

    /**
     * @param string $bestBeforeDate
     *
     * @return ItemVariationStockStorageLocation
     */
    public function setBestBeforeDate($bestBeforeDate)
    {
        $this->bestBeforeDate = $bestBeforeDate;

        return $this;
    }

}