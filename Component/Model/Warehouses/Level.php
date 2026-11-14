<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 19.11.2018
 * Time: 11:16
 */

namespace PM\PlentyMarketsBundle\Component\Model\Warehouses;

use DateTime;

/**
 * Class Level
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Warehouses
 */
class Level
{

    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $parentId = null;

    /** @var int|null */
    private ?int $dimensionId = null;

    /** @var int|null */
    private ?int $position = null;

    /** @var string|null */
    private ?string $pathName = null;

    /** @var string|null */
    private ?string $pickupPathPosition = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

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
     * @return Level
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int|null $parentId
     *
     * @return Level
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return int
     */
    public function getDimensionId()
    {
        return $this->dimensionId;
    }

    /**
     * @param int $dimensionId
     *
     * @return Level
     */
    public function setDimensionId($dimensionId)
    {
        $this->dimensionId = $dimensionId;

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
     * @return Level
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getPathName()
    {
        return $this->pathName;
    }

    /**
     * @param string $pathName
     *
     * @return Level
     */
    public function setPathName($pathName)
    {
        $this->pathName = $pathName;

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
     * @return Level
     */
    public function setPickupPathPosition($pickupPathPosition)
    {
        $this->pickupPathPosition = $pickupPathPosition;

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
     * @return Level
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return Level
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
     * @return Level
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}