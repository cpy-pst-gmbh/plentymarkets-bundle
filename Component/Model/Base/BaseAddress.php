<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 26.07.2017
 * Time: 13:17
 */

namespace PM\PlentyMarketsBundle\Component\Model\Base;



/**
 * Class BaseAddress
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Base
 */
class BaseAddress
{
    /** @var string|null */
    private ?string $name1 = null;

    /** @var string|null */
    private ?string $address1 = null;

    /** @var string|null */
    private ?string $address2 = null;

    /** @var string|null */
    private ?string $postalCode = null;

    /** @var string|null */
    private ?string $town = null;

    /** @var int|null */
    private ?int $countryId = null;

    /** @var array|null */
    private ?array $options = null;

    /**
     * @return string
     */
    public function getName1()
    {
        return $this->name1;
    }

    /**
     * @param string $name1
     *
     * @return BaseAddress
     */
    public function setName1($name1)
    {
        $this->name1 = $name1;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     *
     * @return BaseAddress
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     *
     * @return BaseAddress
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     *
     * @return BaseAddress
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $town
     *
     * @return BaseAddress
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     *
     * @return BaseAddress
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return BaseAddress
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

}