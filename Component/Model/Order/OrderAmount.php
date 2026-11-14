<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 09:04
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use PM\PlentyMarketsBundle\Component\Model\Base\BaseAmount;
use PM\PlentyMarketsBundle\Component\Model\Base\BaseVat;

/**
 * Class OrderAmount
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderAmount extends BaseAmount
{

    /** @var bool|null */
    private ?bool $isNet = null;

    /** @var float|null */
    private ?float $netTotal = null;
    /** @var float|null */
    private ?float $grossTotal = null;
    /** @var float|null */
    private ?float $vatTotal = null;
    /** @var float|null */
    private ?float $invoiceTotal = null;
    /** @var float|null */
    private ?float $paidAmount = null;

    /** @var float|null */
    private ?float $shippingCostsGross = null;

    /** @var float|null */
    private ?float $shippingCostsNet = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Base\BaseVat>|null */
    private ?array $vats = null;

    /**
     * @return boolean
     */
    public function isIsNet()
    {
        return $this->isNet;
    }

    /**
     * @param boolean $isNet
     *
     * @return OrderAmount
     */
    public function setIsNet($isNet)
    {
        $this->isNet = $isNet;

        return $this;
    }

    /**
     * @return float
     */
    public function getNetTotal()
    {
        return $this->netTotal;
    }

    /**
     * @param float $netTotal
     *
     * @return OrderAmount
     */
    public function setNetTotal($netTotal)
    {
        $this->netTotal = $netTotal;

        return $this;
    }

    /**
     * @return float
     */
    public function getGrossTotal()
    {
        return $this->grossTotal;
    }

    /**
     * @param float $grossTotal
     *
     * @return OrderAmount
     */
    public function setGrossTotal($grossTotal)
    {
        $this->grossTotal = $grossTotal;

        return $this;
    }

    /**
     * @return float
     */
    public function getVatTotal()
    {
        return $this->vatTotal;
    }

    /**
     * @param float $vatTotal
     *
     * @return OrderAmount
     */
    public function setVatTotal($vatTotal)
    {
        $this->vatTotal = $vatTotal;

        return $this;
    }

    /**
     * @return float
     */
    public function getInvoiceTotal()
    {
        return $this->invoiceTotal;
    }

    /**
     * @param float $invoiceTotal
     *
     * @return OrderAmount
     */
    public function setInvoiceTotal($invoiceTotal)
    {
        $this->invoiceTotal = $invoiceTotal;

        return $this;
    }

    /**
     * @return float
     */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    /**
     * @param float $paidAmount
     *
     * @return OrderAmount
     */
    public function setPaidAmount($paidAmount)
    {
        $this->paidAmount = $paidAmount;

        return $this;
    }

    public function getShippingCostsGross(): ?float
    {
        return $this->shippingCostsGross;
    }

    public function setShippingCostsGross(?float $shippingCostsGross): self
    {
        $this->shippingCostsGross = $shippingCostsGross;

        return $this;
    }

    public function getShippingCostsNet(): ?float
    {
        return $this->shippingCostsNet;
    }

    public function setShippingCostsNet(?float $shippingCostsNet): self
    {
        $this->shippingCostsNet = $shippingCostsNet;

        return $this;
    }

    /**
     * @return BaseVat
     */
    public function getVats()
    {
        return $this->vats;
    }

    /**
     * @param BaseVat $vats
     *
     * @return OrderAmount
     */
    public function setVats($vats)
    {
        $this->vats = $vats;

        return $this;
    }

}