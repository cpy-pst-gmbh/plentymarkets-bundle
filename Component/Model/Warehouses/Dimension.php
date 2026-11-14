<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 19.11.2018
 * Time: 11:19
 */

namespace PM\PlentyMarketsBundle\Component\Model\Warehouses;

use DateTime;

/**
 * Class Dimension
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Warehouses
 */
class Dimension
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $parentId = null;

    /** @var int|null */
    private ?int $warehouseId = null;

    /** @var int|null */
    private ?int $level = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var bool|null */
    private ?bool $displayInName = null;

    /** @var string|null */
    private ?string $shortcut = null;

    /** @var string|null */
    private ?string $separator = null;


    /** @var bool|null */
    private ?bool $isActiveForPickupPath = null;

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
     * @return Dimension
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     *
     * @return Dimension
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

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
     * @return Dimension
     */
    public function setWarehouseId($warehouseId)
    {
        $this->warehouseId = $warehouseId;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     *
     * @return Dimension
     */
    public function setLevel($level)
    {
        $this->level = $level;

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
     * @return Dimension
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDisplayInName()
    {
        return $this->displayInName;
    }

    /**
     * @param bool $displayInName
     *
     * @return Dimension
     */
    public function setDisplayInName($displayInName)
    {
        $this->displayInName = $displayInName;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     * @param string $shortcut
     *
     * @return Dimension
     */
    public function setShortcut($shortcut)
    {
        $this->shortcut = $shortcut;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param string $separator
     *
     * @return Dimension
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActiveForPickupPath()
    {
        return $this->isActiveForPickupPath;
    }

    /**
     * @param bool $isActiveForPickupPath
     *
     * @return Dimension
     */
    public function setIsActiveForPickupPath($isActiveForPickupPath)
    {
        $this->isActiveForPickupPath = $isActiveForPickupPath;

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
     * @return Dimension
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
     * @return Dimension
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}