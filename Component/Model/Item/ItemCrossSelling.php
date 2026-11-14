<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 11:15
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Class ItemCrossSelling
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemCrossSelling
{
    /** @var int|null */
    private ?int $itemId = null;

    /** @var int|null */
    private ?int $crossItemId = null;

    /** @var string|null */
    private ?string $relationship = null;

    /** @var bool|null */
    private ?bool $isDynamic = null;

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     *
     * @return ItemCrossSelling
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCrossItemId()
    {
        return $this->crossItemId;
    }

    /**
     * @param int $crossItemId
     *
     * @return ItemCrossSelling
     */
    public function setCrossItemId($crossItemId)
    {
        $this->crossItemId = $crossItemId;

        return $this;
    }

    /**
     * @return string
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * @param string $relationship
     *
     * @return ItemCrossSelling
     */
    public function setRelationship($relationship)
    {
        $this->relationship = $relationship;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsDynamic()
    {
        return $this->isDynamic;
    }

    /**
     * @param boolean $isDynamic
     *
     * @return ItemCrossSelling
     */
    public function setIsDynamic($isDynamic)
    {
        $this->isDynamic = $isDynamic;

        return $this;
    }

}