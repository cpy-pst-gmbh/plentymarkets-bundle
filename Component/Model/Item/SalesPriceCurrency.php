<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 19.03.2018
 * Time: 10:34
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;


use DateTime;

/**
 * Class SalesPriceCurrency
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class SalesPriceCurrency
{
    /** @var int|null */
    private ?int $salesPriceId = null;

    /** @var string|null */
    private ?string $currency = null;

    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

    /**
     * @return int
     */
    public function getSalesPriceId()
    {
        return $this->salesPriceId;
    }

    /**
     * @param int $salesPriceId
     *
     * @return SalesPriceCurrency
     */
    public function setSalesPriceId($salesPriceId)
    {
        $this->salesPriceId = $salesPriceId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return SalesPriceCurrency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

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
     * @return SalesPriceCurrency
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
     * @return SalesPriceCurrency
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}