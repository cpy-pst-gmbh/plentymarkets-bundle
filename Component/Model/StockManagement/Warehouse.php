<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 26.07.2017
 * Time: 13:16
 */

namespace PM\PlentyMarketsBundle\Component\Model\StockManagement;

use PM\PlentyMarketsBundle\Component\Model\Base\BaseAddress;


/**
 * Class Warehouse
 *
 * @package PM\PlentyMarketsBundle\Component\Model\StockManagement
 */
class Warehouse
{
    /** @var int|null */
    private ?int $id = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var string|null */
    private ?string $note = null;

    /** @var int|null */
    private ?int $typeId = null;

    /** @var int|null */
    private ?int $onStockAvailability = null;

    /** @var int|null */
    private ?int $outOfStockAvailability = null;

    /** @var bool|null */
    private ?bool $splitByShippingProfile = null;

    /** @var string|null */
    private ?string $storageLocationType = null;

    /** @var int|null */
    private ?int $storageLocationZone = null;

    /** @var int|null */
    private ?int $repairWarehouseId = null;

    /** @var bool|null */
    private ?bool $isInventoryModeActive = null;

    /** @var string|null */
    private ?string $logisticsType = null;

    /** @var \PM\PlentyMarketsBundle\Component\Model\Base\BaseAddress|null */
    private ?\PM\PlentyMarketsBundle\Component\Model\Base\BaseAddress $address = null;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Warehouse
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Warehouse
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     *
     * @return Warehouse
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param int $typeId
     *
     * @return Warehouse
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * @return int
     */
    public function getOnStockAvailability()
    {
        return $this->onStockAvailability;
    }

    /**
     * @param int $onStockAvailability
     *
     * @return Warehouse
     */
    public function setOnStockAvailability($onStockAvailability)
    {
        $this->onStockAvailability = $onStockAvailability;

        return $this;
    }

    /**
     * @return int
     */
    public function getOutOfStockAvailability()
    {
        return $this->outOfStockAvailability;
    }

    /**
     * @param int $outOfStockAvailability
     *
     * @return Warehouse
     */
    public function setOutOfStockAvailability($outOfStockAvailability)
    {
        $this->outOfStockAvailability = $outOfStockAvailability;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSplitByShippingProfile()
    {
        return $this->splitByShippingProfile;
    }

    /**
     * @param boolean $splitByShippingProfile
     *
     * @return Warehouse
     */
    public function setSplitByShippingProfile($splitByShippingProfile)
    {
        $this->splitByShippingProfile = $splitByShippingProfile;

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
     * @return Warehouse
     */
    public function setStorageLocationType($storageLocationType)
    {
        $this->storageLocationType = $storageLocationType;

        return $this;
    }

    /**
     * @return int
     */
    public function getStorageLocationZone()
    {
        return $this->storageLocationZone;
    }

    /**
     * @param int $storageLocationZone
     *
     * @return Warehouse
     */
    public function setStorageLocationZone($storageLocationZone)
    {
        $this->storageLocationZone = $storageLocationZone;

        return $this;
    }

    /**
     * @return int
     */
    public function getRepairWarehouseId()
    {
        return $this->repairWarehouseId;
    }

    /**
     * @param int $repairWarehouseId
     *
     * @return Warehouse
     */
    public function setRepairWarehouseId($repairWarehouseId)
    {
        $this->repairWarehouseId = $repairWarehouseId;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsInventoryModeActive()
    {
        return $this->isInventoryModeActive;
    }

    /**
     * @param boolean $isInventoryModeActive
     *
     * @return Warehouse
     */
    public function setIsInventoryModeActive($isInventoryModeActive)
    {
        $this->isInventoryModeActive = $isInventoryModeActive;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogisticsType()
    {
        return $this->logisticsType;
    }

    /**
     * @param string $logisticsType
     *
     * @return Warehouse
     */
    public function setLogisticsType($logisticsType)
    {
        $this->logisticsType = $logisticsType;

        return $this;
    }

    /**
     * @return \PM\PlentyMarketsBundle\Component\Model\Base\BaseAddress[]
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param \PM\PlentyMarketsBundle\Component\Model\Base\BaseAddress[] $address
     *
     * @return Warehouse
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

}