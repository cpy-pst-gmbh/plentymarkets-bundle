<?php


namespace PM\PlentyMarketsBundle\Component\Model\Item;

use JMS\Serializer\Annotation as JMS;

/**
 * Class ItemVariationCharacteristic
 *
 * Merkmal (alte Eigenschaft) einer Variante, with=variationProperties
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
#[JMS\ExclusionPolicy('ALL')]
class ItemVariationCharacteristic
{
    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $id;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $itemId;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $variationId;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $propertyId;

    /**
     * @var int|null
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $propertySelectionId;

    /**
     * @var int|null
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $valueInt;

    /**
     * @var float|null
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $valueFloat;

    /**
     * @var string|null
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $valueFile;

    /**
     * @var float
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $surcharge;

    /**
     * @var array|ItemVariationCharacteristicName[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationCharacteristicName>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $names = [];

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
     * @return ItemVariationCharacteristic
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return ItemVariationCharacteristic
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * @return int
     */
    public function getVariationId()
    {
        return $this->variationId;
    }

    /**
     * @param int $variationId
     *
     * @return ItemVariationCharacteristic
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @param int $propertyId
     *
     * @return ItemVariationCharacteristic
     */
    public function setPropertyId($propertyId)
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPropertySelectionId()
    {
        return $this->propertySelectionId;
    }

    /**
     * @param int|null $propertySelectionId
     *
     * @return ItemVariationCharacteristic
     */
    public function setPropertySelectionId($propertySelectionId)
    {
        $this->propertySelectionId = $propertySelectionId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getValueInt()
    {
        return $this->valueInt;
    }

    /**
     * @param int|null $valueInt
     *
     * @return ItemVariationCharacteristic
     */
    public function setValueInt($valueInt)
    {
        $this->valueInt = $valueInt;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getValueFloat()
    {
        return $this->valueFloat;
    }

    /**
     * @param float|null $valueFloat
     *
     * @return ItemVariationCharacteristic
     */
    public function setValueFloat($valueFloat)
    {
        $this->valueFloat = $valueFloat;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValueFile()
    {
        return $this->valueFile;
    }

    /**
     * @param string|null $valueFile
     *
     * @return ItemVariationCharacteristic
     */
    public function setValueFile($valueFile)
    {
        $this->valueFile = $valueFile;

        return $this;
    }

    /**
     * @return float
     */
    public function getSurcharge()
    {
        return $this->surcharge;
    }

    /**
     * @param float $surcharge
     *
     * @return ItemVariationCharacteristic
     */
    public function setSurcharge($surcharge)
    {
        $this->surcharge = $surcharge;

        return $this;
    }

    /**
     * @return array|ItemVariationCharacteristicName[]
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param array|ItemVariationCharacteristicName[] $names
     *
     * @return ItemVariationCharacteristic
     */
    public function setNames($names)
    {
        $this->names = $names;

        return $this;
    }
}
