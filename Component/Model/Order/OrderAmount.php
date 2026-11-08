<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 09:04
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\Base\BaseAmount;
use PM\PlentyMarketsBundle\Component\Model\Base\BaseVat;

/**
 * Class OrderAmount
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
#[JMS\ExclusionPolicy('ALL')]
class OrderAmount extends BaseAmount
{

    /**
     * @var bool
     */
    #[JMS\Type('boolean')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $isNet;

    /**
     * @var float
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $netTotal;
    /**
     * @var float
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $grossTotal;
    /**
     * @var float
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $vatTotal;
    /**
     * @var float
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $invoiceTotal;
    /**
     * @var float
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $paidAmount;

    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?float $shippingCostsGross = null;

    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?float $shippingCostsNet = null;

    /**
     * @var BaseVat
     *
     *
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Base\BaseVat>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $vats;

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