<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 13.07.2017
 * Time: 10:40
 */

namespace PM\PlentyMarketsBundle\Component\Model\Payment;


/**
 * Class PaymentMethod
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Payment
 */
class PaymentMethod
{
    /** @var int|null */
    private ?int $id = null;

    /** @var string|null */
    private ?string $pluginKey = null;

    /** @var string|null */
    private ?string $paymentKey = null;

    /** @var string|null */
    private ?string $name = null;

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
     * @return PaymentMethod
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPluginKey()
    {
        return $this->pluginKey;
    }

    /**
     * @param string $pluginKey
     *
     * @return PaymentMethod
     */
    public function setPluginKey($pluginKey)
    {
        $this->pluginKey = $pluginKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentKey()
    {
        return $this->paymentKey;
    }

    /**
     * @param string $paymentKey
     *
     * @return PaymentMethod
     */
    public function setPaymentKey($paymentKey)
    {
        $this->paymentKey = $paymentKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return PaymentMethod
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

}