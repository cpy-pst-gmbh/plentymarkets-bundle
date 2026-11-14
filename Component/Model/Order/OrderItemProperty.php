<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 08:49
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use DateTime;
use PM\PlentyMarketsBundle\Component\Traits\HasConstantsTrait;

/**
 * Class OrderItemProperty
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderItemProperty
{
    use HasConstantsTrait;

    const WAREHOUSE = 1;
    const SHIPPING_PROFILE = 2;
    const PAYMENT_METHOD = 3;
    const WEIGHT = 11;
    const WIDTH = 12;
    const LENGTH = 13;
    const HEIGHT = 14;
    const EXTERNAL_TOKEN_ID = 16;
    const EXTERNAL_ITEM_ID = 17;
    const COUPON_CODE = 18;
    const COUPON_TYPE = 19;
    const ORIGINAL_WAREHOUSE = 20;
    const ORIGINAL_QUANTITY = 21;
    const CATEGORY_ID = 22;
    const MARKET_FEE = 23;
    const STOCK_REVERSING = 24;
    const DISPUTE_STATUS = 25;
    const NO_CHANGE_BY_CONTACT = 26;
    const SIZE = 29;
    const LOCATION_RESERVED = 30;
    const EXTERNAL_SHIPMENT_ITEM_ID = 31;
    const PARTIAL_SHIPPING_COSTS = 32;
    const MAIN_DOCUMENT_NUMBER = 33;
    const SALES_TAX_ID_NUMBER = 34;
    const RETURNS_REASON = 35;
    const RETURNS_ITEM_STATUS = 36;
    const FULFILLMENT_CENTER_ID = 37;
    const FULFILLMENT_CENTER_COUNTRY_ISO = 38;
    const REORDER_ITEM_ID = 39;
    const LISTING_TYPE = 40;

    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $orderItemId = null;

    /** @var int|null */
    private ?int $typeId = null;

    /** @var string|null */
    private ?string $value = null;

    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

    /**
     * @return int
     */
    public function getOrderItemId()
    {
        return $this->orderItemId;
    }

    /**
     * @param int $orderItemId
     *
     * @return OrderItemProperty
     */
    public function setOrderItemId($orderItemId)
    {
        $this->orderItemId = $orderItemId;

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
     * @return OrderItemProperty
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
     * @return OrderItemProperty
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

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
     * @return OrderItemProperty
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return OrderItemProperty
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     *
     * @return OrderItemProperty
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}