<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 19.03.2018
 * Time: 10:25
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;

/**
 * Class SalesPrice
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class SalesPrice
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $position = null;

    /** @var float|null */
    private ?float $minimumOrderQuantity = null;

    /** @var string|null */
    private ?string $type = null;

    /** @var bool|null */
    private ?bool $isCustomerPrice = null;

    /** @var bool|null */
    private ?bool $isDisplayedByDefault = null;

    /** @var bool|null */
    private ?bool $isLiveConversion = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\SalesPriceName>|null */
    private ?array $names = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\SalesPriceAccount>|null */
    private ?array $accounts = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\SalesPriceCountry>|null */
    private ?array $countries = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\SalesPriceCurrency>|null */
    private ?array $currencies = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\SalesPriceCustomerClass>|null */
    private ?array $customerClasses = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\SalesPriceReferrer>|null */
    private ?array $referrers = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\SalesPriceOnlineStore>|null */
    private ?array $clients = null;

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
     * @return SalesPrice
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return SalesPrice
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return float
     */
    public function getMinimumOrderQuantity()
    {
        return $this->minimumOrderQuantity;
    }

    /**
     * @param float $minimumOrderQuantity
     *
     * @return SalesPrice
     */
    public function setMinimumOrderQuantity($minimumOrderQuantity)
    {
        $this->minimumOrderQuantity = $minimumOrderQuantity;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return SalesPrice
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCustomerPrice()
    {
        return $this->isCustomerPrice;
    }

    /**
     * @param bool $isCustomerPrice
     *
     * @return SalesPrice
     */
    public function setIsCustomerPrice($isCustomerPrice)
    {
        $this->isCustomerPrice = $isCustomerPrice;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDisplayedByDefault()
    {
        return $this->isDisplayedByDefault;
    }

    /**
     * @param bool $isDisplayedByDefault
     *
     * @return SalesPrice
     */
    public function setIsDisplayedByDefault($isDisplayedByDefault)
    {
        $this->isDisplayedByDefault = $isDisplayedByDefault;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLiveConversion()
    {
        return $this->isLiveConversion;
    }

    /**
     * @param bool $isLiveConversion
     *
     * @return SalesPrice
     */
    public function setIsLiveConversion($isLiveConversion)
    {
        $this->isLiveConversion = $isLiveConversion;

        return $this;
    }

    /**
     * @return SalesPriceName[]
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param SalesPriceName[] $names
     *
     * @return SalesPrice
     */
    public function setNames($names)
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @return SalesPriceAccount[]
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * @param SalesPriceAccount[] $accounts
     *
     * @return SalesPrice
     */
    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;

        return $this;
    }

    /**
     * @return SalesPriceCountry[]
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * @param SalesPriceCountry[] $countries
     *
     * @return SalesPrice
     */
    public function setCountries($countries)
    {
        $this->countries = $countries;

        return $this;
    }

    /**
     * @return SalesPriceCurrency[]
     */
    public function getCurrencies()
    {
        return $this->currencies;
    }

    /**
     * @param SalesPriceCurrency[] $currencies
     *
     * @return SalesPrice
     */
    public function setCurrencies($currencies)
    {
        $this->currencies = $currencies;

        return $this;
    }

    /**
     * @return SalesPriceCustomerClass[]
     */
    public function getCustomerClasses()
    {
        return $this->customerClasses;
    }

    /**
     * @param SalesPriceCustomerClass[] $customerClasses
     *
     * @return SalesPrice
     */
    public function setCustomerClasses($customerClasses)
    {
        $this->customerClasses = $customerClasses;

        return $this;
    }

    /**
     * @return SalesPriceReferrer[]
     */
    public function getReferrers()
    {
        return $this->referrers;
    }

    /**
     * @param SalesPriceReferrer[] $referrers
     *
     * @return SalesPrice
     */
    public function setReferrers($referrers)
    {
        $this->referrers = $referrers;

        return $this;
    }

    /**
     * @return SalesPriceOnlineStore[]
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @param SalesPriceOnlineStore[] $clients
     *
     * @return SalesPrice
     */
    public function setClients($clients)
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * Get Name By Language
     *
     * @param string $language
     *
     * @return null|SalesPriceName
     */
    public function getNameByLanguage($language)
    {
        foreach ($this->getNames() as $name) {
            if ($name->getLang() === $language) {
                return $name;
            }
        }

        return null;
    }
}