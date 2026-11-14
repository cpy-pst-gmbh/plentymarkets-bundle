<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 09:03
 */

namespace PM\PlentyMarketsBundle\Component\Model\Base;


/**
 * Class BaseAmount
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Base
 */
class BaseAmount
{

    /** @var bool|null */
    private ?bool $isSystemCurrency = null;


    /** @var string|null */
    private ?string $currency = null;

    /** @var float|null */
    private ?float $exchangeRate = null;

    /**
     * @return boolean
     */
    public function isIsSystemCurrency()
    {
        return $this->isSystemCurrency;
    }

    /**
     * @param boolean $isSystemCurrency
     *
     * @return BaseAmount
     */
    public function setIsSystemCurrency($isSystemCurrency)
    {
        $this->isSystemCurrency = $isSystemCurrency;

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
     * @return BaseAmount
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return float
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * @param float $exchangeRate
     *
     * @return BaseAmount
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;

        return $this;
    }

}