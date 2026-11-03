<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 19.03.2018
 * Time: 11:07
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;
use JMS\Serializer\Annotation as JMS;

/**
 * Class ItemVariationSalesPrice
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
#[JMS\ExclusionPolicy('ALL')]
class ItemVariationSalesPrice
{
    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $variationId;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $salesPriceId;

    /**
     * @var float
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $price;

    /**
     * @var float|null
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $lowestPrice;

    /**
     * @var bool
     */
    #[JMS\Type('boolean')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $lowestPriceCalculation;


    /**
     * @var DateTime
     */
    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $createdAt;

    /**
     * @var DateTime
     */
    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $updatedAt;

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