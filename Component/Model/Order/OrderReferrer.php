<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 07.08.2017
 * Time: 10:18
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;


/**
 * Class OrderReferrer
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderReferrer
{
    /** @var float|null */
    private ?float $id = null;

    /** @var bool|null */
    private ?bool $isEditable = null;

    /** @var bool|null */
    private ?bool $isFilterable = null;

    /** @var string|null */
    private ?string $backendName = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var string|null */
    private ?string $origin = null;

    /** @var int|null */
    private ?int $orderOwnerId = null;

    /**
     * @return float
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param float $id
     *
     * @return OrderReferrer
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsEditable()
    {
        return $this->isEditable;
    }

    /**
     * @param boolean $isEditable
     *
     * @return OrderReferrer
     */
    public function setIsEditable($isEditable)
    {
        $this->isEditable = $isEditable;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsFilterable()
    {
        return $this->isFilterable;
    }

    /**
     * @param boolean $isFilterable
     *
     * @return OrderReferrer
     */
    public function setIsFilterable($isFilterable)
    {
        $this->isFilterable = $isFilterable;

        return $this;
    }

    /**
     * @return string
     */
    public function getBackendName()
    {
        return $this->backendName;
    }

    /**
     * @param string $backendName
     *
     * @return OrderReferrer
     */
    public function setBackendName($backendName)
    {
        $this->backendName = $backendName;

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
     * @return OrderReferrer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     *
     * @return OrderReferrer
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderOwnerId()
    {
        return $this->orderOwnerId;
    }

    /**
     * @param int $orderOwnerId
     *
     * @return OrderReferrer
     */
    public function setOrderOwnerId($orderOwnerId)
    {
        $this->orderOwnerId = $orderOwnerId;

        return $this;
    }

}