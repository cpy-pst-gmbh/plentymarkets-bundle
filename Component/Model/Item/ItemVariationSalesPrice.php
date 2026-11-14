<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 19.03.2018
 * Time: 11:07
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;

/**
 * Class ItemVariationSalesPrice
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationSalesPrice
{
    /** @var int|null */
    private ?int $variationId = null;

    /** @var int|null */
    private ?int $salesPriceId = null;

    /** @var float|null */
    private ?float $price = null;

    /** @var float|null */
    private ?float $lowestPrice = null;

    /** @var bool|null */
    private ?bool $lowestPriceCalculation = null;


    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

    /**
     * @return int
     */
    public function getVariationId()
    {
        return $this->variationId;
    }

    /**
     * @param int $variationId
     *
     * @return ItemVariationSalesPrice
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;

        return $this;
    }

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
     * @return ItemVariationSalesPrice
     */
    public function setSalesPriceId($salesPriceId)
    {
        $this->salesPriceId = $salesPriceId;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return ItemVariationSalesPrice
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLowestPrice()
    {
        return $this->lowestPrice;
    }

    /**
     * @param float|null $lowestPrice
     *
     * @return ItemVariationSalesPrice
     */
    public function setLowestPrice($lowestPrice)
    {
        $this->lowestPrice = $lowestPrice;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLowestPriceCalculation()
    {
        return $this->lowestPriceCalculation;
    }

    /**
     * @param bool $lowestPriceCalculation
     *
     * @return ItemVariationSalesPrice
     */
    public function setLowestPriceCalculation($lowestPriceCalculation)
    {
        $this->lowestPriceCalculation = $lowestPriceCalculation;

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
     * @return ItemVariationSalesPrice
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
     * @return ItemVariationSalesPrice
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}