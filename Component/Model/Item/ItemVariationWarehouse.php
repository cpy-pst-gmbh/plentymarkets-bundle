<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 08.01.2019
 * Time: 12:41
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;

/**
 * Class ItemVariationWarehouse
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationWarehouse
{

    /** @var int|null */
    private ?int $variationId = null;

    /** @var int|null */
    private ?int $warehouseId = null;

    /** @var int|null */
    private ?int $warehouseZoneId = null;

    /** @var int|null */
    private ?int $reorderLevel = null;

    /** @var int|null */
    private ?int $maximumStock = null;

    /** @var int|null */
    private ?int $stuckTurnoverInDays = null;

    /** @var int|null */
    private ?int $storageLocation = null;

    /** @var int|null */
    private ?int $stockBuffer = null;

    /** @var string|null */
    private ?string $storageLocationType = null;

    /** @var \DateTime|null */
    private ?\DateTime $lastUpdateTimestamp = null;

    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var bool|null */
    private ?bool $isBatch = null;

    /** @var bool|null */
    private ?bool $isBestBeforeDate = null;

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
     * @return ItemVariationWarehouse
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
     * @return ItemVariationWarehouse
     */
    public function setWarehouseId($warehouseId)
    {
        $this->warehouseId = $warehouseId;

        return $this;
    }

    /**
     * @return int
     */
    public function getWarehouseZoneId()
    {
        return $this->warehouseZoneId;
    }

    /**
     * @param int $warehouseZoneId
     *
     * @return ItemVariationWarehouse
     */
    public function setWarehouseZoneId($warehouseZoneId)
    {
        $this->warehouseZoneId = $warehouseZoneId;

        return $this;
    }

    /**
     * @return int
     */
    public function getReorderLevel()
    {
        return $this->reorderLevel;
    }

    /**
     * @param int $reorderLevel
     *
     * @return ItemVariationWarehouse
     */
    public function setReorderLevel($reorderLevel)
    {
        $this->reorderLevel = $reorderLevel;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaximumStock()
    {
        return $this->maximumStock;
    }

    /**
     * @param int $maximumStock
     *
     * @return ItemVariationWarehouse
     */
    public function setMaximumStock($maximumStock)
    {
        $this->maximumStock = $maximumStock;

        return $this;
    }

    /**
     * @return int
     */
    public function getStuckTurnoverInDays()
    {
        return $this->stuckTurnoverInDays;
    }

    /**
     * @param int $stuckTurnoverInDays
     *
     * @return ItemVariationWarehouse
     */
    public function setStuckTurnoverInDays($stuckTurnoverInDays)
    {
        $this->stuckTurnoverInDays = $stuckTurnoverInDays;

        return $this;
    }

    /**
     * @return int
     */
    public function getStorageLocation()
    {
        return $this->storageLocation;
    }

    /**
     * @param int $storageLocation
     *
     * @return ItemVariationWarehouse
     */
    public function setStorageLocation($storageLocation)
    {
        $this->storageLocation = $storageLocation;

        return $this;
    }

    /**
     * @return int
     */
    public function getStockBuffer()
    {
        return $this->stockBuffer;
    }

    /**
     * @param int $stockBuffer
     *
     * @return ItemVariationWarehouse
     */
    public function setStockBuffer($stockBuffer)
    {
        $this->stockBuffer = $stockBuffer;

        return $this;
    }

    /**
     * @return string
     */
    public function getStorageLocationType()
    {
        return $this->storageLocationType;
    }

    /**
     * @param string $storageLocationType
     *
     * @return ItemVariationWarehouse
     */
    public function setStorageLocationType($storageLocationType)
    {
        $this->storageLocationType = $storageLocationType;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastUpdateTimestamp()
    {
        return $this->lastUpdateTimestamp;
    }

    /**
     * @param DateTime $lastUpdateTimestamp
     *
     * @return ItemVariationWarehouse
     */
    public function setLastUpdateTimestamp($lastUpdateTimestamp)
    {
        $this->lastUpdateTimestamp = $lastUpdateTimestamp;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return ItemVariationWarehouse
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBatch()
    {
        return $this->isBatch;
    }

    /**
     * @param bool $isBatch
     *
     * @return ItemVariationWarehouse
     */
    public function setIsBatch($isBatch)
    {
        $this->isBatch = $isBatch;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBestBeforeDate()
    {
        return $this->isBestBeforeDate;
    }

    /**
     * @param bool $isBestBeforeDate
     *
     * @return ItemVariationWarehouse
     */
    public function setIsBestBeforeDate($isBestBeforeDate)
    {
        $this->isBestBeforeDate = $isBestBeforeDate;

        return $this;
    }

}