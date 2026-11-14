<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 10.12.2018
 * Time: 14:36
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Class ItemImageAvailability
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemImageAvailability
{
    /** @var int|null */
    private ?int $imageId = null;

    /** @var string|null */
    private ?string $type = null;

    /** @var float|null */
    private ?float $value = null;

    /**
     * @return int
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * @param int $imageId
     *
     * @return ItemImageAvailability
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

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
     * @return ItemImageAvailability
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * @return ItemImageAvailability
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

}