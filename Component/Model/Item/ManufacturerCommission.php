<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 31.08.2017
 * Time: 11:39
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Class ManufacturerCommission
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ManufacturerCommission
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $manufacturerId = null;

    /** @var int|null */
    private ?int $plentyId = null;

    /** @var float|null */
    private ?float $referrerId = null;

    /** @var float|null */
    private ?float $commission = null;

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
     * @return ManufacturerCommission
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getManufacturerId()
    {
        return $this->manufacturerId;
    }

    /**
     * @param int $manufacturerId
     *
     * @return ManufacturerCommission
     */
    public function setManufacturerId($manufacturerId)
    {
        $this->manufacturerId = $manufacturerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlentyId()
    {
        return $this->plentyId;
    }

    /**
     * @param int $plentyId
     *
     * @return ManufacturerCommission
     */
    public function setPlentyId($plentyId)
    {
        $this->plentyId = $plentyId;

        return $this;
    }

    /**
     * @return float
     */
    public function getReferrerId()
    {
        return $this->referrerId;
    }

    /**
     * @param float $referrerId
     *
     * @return ManufacturerCommission
     */
    public function setReferrerId($referrerId)
    {
        $this->referrerId = $referrerId;

        return $this;
    }

    /**
     * @return float
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param float $commission
     *
     * @return ManufacturerCommission
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

}