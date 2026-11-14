<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.09.2017
 * Time: 14:44
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;


/**
 * Class OrderShippingPackage
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderShippingPackage
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $orderId = null;

    /** @var int|null */
    private ?int $packageId = null;

    /** @var int|null */
    private ?int $weight = null;

    /** @var string|null */
    private ?string $packageNumber = null;

    /** @var string|null */
    private ?string $labelPath = null;

    /** @var string|null */
    private ?string $labelBase64 = null;

    /** @var int|null */
    private ?int $packageType = null;

    /** @var float|null */
    private ?float $volume = null;

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
     * @return OrderShippingPackage
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     *
     * @return OrderShippingPackage
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPackageId()
    {
        return $this->packageId;
    }

    /**
     * @param int $packageId
     *
     * @return OrderShippingPackage
     */
    public function setPackageId($packageId)
    {
        $this->packageId = $packageId;

        return $this;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     *
     * @return OrderShippingPackage
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return string
     */
    public function getPackageNumber()
    {
        return $this->packageNumber;
    }

    /**
     * @param string $packageNumber
     *
     * @return OrderShippingPackage
     */
    public function setPackageNumber($packageNumber)
    {
        $this->packageNumber = $packageNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabelPath()
    {
        return $this->labelPath;
    }

    /**
     * @param string $labelPath
     *
     * @return OrderShippingPackage
     */
    public function setLabelPath($labelPath)
    {
        $this->labelPath = $labelPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabelBase64()
    {
        return $this->labelBase64;
    }

    /**
     * @param string $labelBase64
     *
     * @return OrderShippingPackage
     */
    public function setLabelBase64($labelBase64)
    {
        $this->labelBase64 = $labelBase64;

        return $this;
    }

    /**
     * @return int
     */
    public function getPackageType()
    {
        return $this->packageType;
    }

    /**
     * @param int $packageType
     *
     * @return OrderShippingPackage
     */
    public function setPackageType($packageType)
    {
        $this->packageType = $packageType;

        return $this;
    }

    /**
     * @return float
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param float $volume
     *
     * @return OrderShippingPackage
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

}