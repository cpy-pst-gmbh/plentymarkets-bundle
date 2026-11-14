<?php

namespace PM\PlentyMarketsBundle\Component\Model\Order;


class OrderAddressRelation
{
    public const TYPE_ID_BILLING = 1;
    public const TYPE_ID_DELIVERY = 2;

    /** @var int|null */
    private ?int $orderId = null;

    /** @var int|null */
    private ?int $typeId = null;

    /** @var int|null */
    private ?int $addressId = null;

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
     * @return OrderAddressRelation
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
     * @return OrderAddressRelation
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * @return int
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * @param int $addressId
     *
     * @return OrderAddressRelation
     */
    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;

        return $this;
    }

}