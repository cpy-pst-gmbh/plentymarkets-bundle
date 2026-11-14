<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 25.09.2017
 * Time: 13:17
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use DateTime;

/**
 * Class OrderReference
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderReference
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $orderId = null;

    /** @var int|null */
    private ?int $originOrderId = null;

    /** @var int|null */
    private ?int $referenceOrderId = null;

    /** @var string|null */
    private ?string $referenceType = null;

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
     * @return OrderReference
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     *
     * @return OrderReference
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return int
     */
    public function getOriginOrderId()
    {
        return $this->originOrderId;
    }

    /**
     * @param int $originOrderId
     *
     * @return OrderReference
     */
    public function setOriginOrderId($originOrderId)
    {
        $this->originOrderId = $originOrderId;

        return $this;
    }

    /**
     * @return int
     */
    public function getReferenceOrderId()
    {
        return $this->referenceOrderId;
    }

    /**
     * @param int $referenceOrderId
     *
     * @return OrderReference
     */
    public function setReferenceOrderId($referenceOrderId)
    {
        $this->referenceOrderId = $referenceOrderId;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceType()
    {
        return $this->referenceType;
    }

    /**
     * @param string $referenceType
     *
     * @return OrderReference
     */
    public function setReferenceType($referenceType)
    {
        $this->referenceType = $referenceType;

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
     * @return OrderReference
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
     * @return OrderReference
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}