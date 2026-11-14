<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 08:53
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;


/**
 * Class OrderProperty
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderProperty
{
    public const TYPE_WAREHOUSE = 1;
    public const TYPE_SHIPPING_PROFILE = 2;
    public const TYPE_PAYMENT_METHOD = 3;
    public const TYPE_PAYMENT_STATUS = 4;
    public const TYPE_EXTERNAL_SHIPPING_PROFILE = 5;
    public const TYPE_DOCUMENT_LANGUAGE = 6;
    public const TYPE_EXTERNAL_ORDER_ID = 7;
    public const TYPE_CUSTOMER_SIGN = 8;
    public const TYPE_DUNNING_LEVEL = 9;
    public const TYPE_SELLER_ACCOUNT = 10;
    public const TYPE_WEIGHT = 11;
    public const TYPE_WIDTH = 12;
    public const TYPE_LENGTH = 13;
    public const TYPE_HEIGHT = 14;
    public const TYPE_FLAG = 15;
    public const TYPE_EXTERNAL_TOKEN_ID = 16;
    public const TYPE_EXTERNAL_ITEM_ID = 17;
    public const TYPE_COUPON_CODE = 18;
    public const TYPE_COUPON_TYPE = 19;
    public const TYPE_SALES_TAX_ID_NUMBER = 34;
    public const TYPE_MAIN_DOCUMENT_NUMBER = 33;

    /** @var int|null */
    private ?int $orderId = null;

    /** @var int|null */
    private ?int $typeId = null;

    /** @var string|null */
    private ?string $value = null;

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
     * @return OrderProperty
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
     * @return OrderProperty
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return OrderProperty
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

}