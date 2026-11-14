<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 09:05
 */

namespace PM\PlentyMarketsBundle\Component\Model\Base;


/**
 * Class BaseVat
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Base
 */
class BaseVat
{
    /** @var int|null */
    private ?int $vatField = null;

    /** @var int|null */
    private ?int $vatAmount = null;

    /** @var float|null */
    private ?float $value = null;

    /**
     * @return int
     */
    public function getVatField()
    {
        return $this->vatField;
    }

    /**
     * @param int $vatField
     *
     * @return BaseVat
     */
    public function setVatField($vatField)
    {
        $this->vatField = $vatField;

        return $this;
    }

    /**
     * @return int
     */
    public function getVatAmount()
    {
        return $this->vatAmount;
    }

    /**
     * @param int $vatAmount
     *
     * @return BaseVat
     */
    public function setVatAmount($vatAmount)
    {
        $this->vatAmount = $vatAmount;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     *
     * @return BaseVat
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }


}