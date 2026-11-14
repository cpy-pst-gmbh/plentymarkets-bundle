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
 * Class SalesPriceOnlineStore
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class SalesPriceOnlineStore
{
    /** @var int|null */
    private ?int $salesPriceId = null;

    /** @var int|null */
    private ?int $plentyId = null;

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
     * @return SalesPriceOnlineStore
     */
    public function setSalesPriceId($salesPriceId)
    {
        $this->salesPriceId = $salesPriceId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlentyId()
    {
        return $this->plentyId;
    }

    /**
     * @param int $plentyId
     *
     * @return SalesPriceOnlineStore
     */
    public function setPlentyId($plentyId)
    {
        $this->plentyId = $plentyId;

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
     * @return SalesPriceOnlineStore
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
     * @return SalesPriceOnlineStore
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}