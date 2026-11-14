<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 19.03.2018
 * Time: 10:30
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;

/**
 * Class SalesPriceName
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class SalesPriceName
{
    /** @var int|null */
    private ?int $salesPriceId = null;

    /** @var string|null */
    private ?string $lang = null;

    /** @var string|null */
    private ?string $nameInternal = null;

    /** @var string|null */
    private ?string $nameExternal = null;

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
     * @return SalesPriceName
     */
    public function setSalesPriceId($salesPriceId)
    {
        $this->salesPriceId = $salesPriceId;

        return $this;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     *
     * @return SalesPriceName
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return string
     */
    public function getNameInternal()
    {
        return $this->nameInternal;
    }

    /**
     * @param string $nameInternal
     *
     * @return SalesPriceName
     */
    public function setNameInternal($nameInternal)
    {
        $this->nameInternal = $nameInternal;

        return $this;
    }

    /**
     * @return string
     */
    public function getNameExternal()
    {
        return $this->nameExternal;
    }

    /**
     * @param string $nameExternal
     *
     * @return SalesPriceName
     */
    public function setNameExternal($nameExternal)
    {
        $this->nameExternal = $nameExternal;

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
     * @return SalesPriceName
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
     * @return SalesPriceName
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}