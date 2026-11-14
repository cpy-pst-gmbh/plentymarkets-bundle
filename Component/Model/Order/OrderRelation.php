<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 09:01
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;


/**
 * Class OrderRelation
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderRelation
{
    public const REFERENCE_TYPE_CONTACT = 'contact';
    public const RELATION_RECEIVER = 'receiver';

    /** @var int|null */
    private ?int $orderId = null;

    /** @var string|null */
    private ?string $referenceType = null;

    /** @var int|null */
    private ?int $referenceId = null;

    /** @var string|null */
    private ?string $relation = null;

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
     * @return OrderRelation
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

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
     * @return OrderRelation
     */
    public function setReferenceType($referenceType)
    {
        $this->referenceType = $referenceType;

        return $this;
    }

    /**
     * @return int
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /**
     * @param int $referenceId
     *
     * @return OrderRelation
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    /**
     * @return string
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * @param string $relation
     *
     * @return OrderRelation
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

}