<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 19.11.2018
 * Time: 11:23
 */

namespace PM\PlentyMarketsBundle\Component\Model\Warehouses;

use DateTime;

/**
 * Class Location
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Warehouses
 */
class Location
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $levelId = null;

    /** @var string|null */
    private ?string $label = null;

    /** @var string|null */
    private ?string $purposeKey = null;

    /** @var string|null */
    private ?string $statusKey = null;

    /** @var int|null */
    private ?int $position = null;

    /** @var string|null */
    private ?string $type = null;

    /** @var string|null */
    private ?string $pickupPathPosition = null;

    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

    /** @var string|null */
    private ?string $fullLabel = null;

    /** @var \PM\PlentyMarketsBundle\Component\Model\Warehouses\Level|null */
    private ?\PM\PlentyMarketsBundle\Component\Model\Warehouses\Level $warehouseLocationLevel = null;

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
     * @return Location
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevelId()
    {
        return $this->levelId;
    }

    /**
     * @param int $levelId
     *
     * @return Location
     */
    public function setLevelId($levelId)
    {
        $this->levelId = $levelId;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return Location
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getPurposeKey()
    {
        return $this->purposeKey;
    }

    /**
     * @param string $purposeKey
     *
     * @return Location
     */
    public function setPurposeKey($purposeKey)
    {
        $this->purposeKey = $purposeKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusKey()
    {
        return $this->statusKey;
    }

    /**
     * @param string $statusKey
     *
     * @return Location
     */
    public function setStatusKey($statusKey)
    {
        $this->statusKey = $statusKey;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return Location
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Location
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getPickupPathPosition()
    {
        return $this->pickupPathPosition;
    }

    /**
     * @param string $pickupPathPosition
     *
     * @return Location
     */
    public function setPickupPathPosition($pickupPathPosition)
    {
        $this->pickupPathPosition = $pickupPathPosition;

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
     * @return Location
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

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
     * @return Location
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullLabel()
    {
        return $this->fullLabel;
    }

    /**
     * @param string $fullLabel
     *
     * @return Location
     */
    public function setFullLabel($fullLabel)
    {
        $this->fullLabel = $fullLabel;

        return $this;
    }

    /**
     * @return Level
     */
    public function getWarehouseLocationLevel()
    {
        return $this->warehouseLocationLevel;
    }

    /**
     * @param Level $warehouseLocationLevel
     *
     * @return Location
     */
    public function setWarehouseLocationLevel($warehouseLocationLevel)
    {
        $this->warehouseLocationLevel = $warehouseLocationLevel;

        return $this;
    }

}