<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 09:09
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use DateTime;

/**
 * Class OrderDate
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderDate
{
    /** @var int|null */
    private ?int $orderId = null;

    /** @var int|null */
    private ?int $typeId = null;

    /** @var \DateTime|null */
    private ?\DateTime $date = null;

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
     * @return OrderDate
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

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
     * @return OrderDate
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     *
     * @return OrderDate
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

}