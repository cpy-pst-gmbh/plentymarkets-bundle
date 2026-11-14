<?php


namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Class ItemVariationCharacteristic
 *
 * Merkmal (alte Eigenschaft) einer Variante, with=variationProperties
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationCharacteristic
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $itemId = null;

    /** @var int|null */
    private ?int $variationId = null;

    /** @var int|null */
    private ?int $propertyId = null;

    /** @var int|null */
    private ?int $propertySelectionId = null;

    /** @var int|null */
    private ?int $valueInt = null;

    /** @var float|null */
    private ?float $valueFloat = null;

    /** @var string|null */
    private ?string $valueFile = null;

    /** @var float|null */
    private ?float $surcharge = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationCharacteristicName>|null */
    private ?array $names = [];

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
