<?php


namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Class ItemVariationMarketNumber
 *
 * Marktplatz-Nummer einer Variante wie die ASIN, with=marketItemNumbers
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationMarketNumber
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $variationId = null;

    /** @var int|null */
    private ?int $countryId = null;

    /** @var string|null */
    private ?string $type = null;

    /** @var int|null */
    private ?int $position = null;

    /** @var string|null */
    private ?string $value = null;

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
     * @return ItemVariationMarketNumber
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return ItemVariationMarketNumber
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     *
     * @return ItemVariationMarketNumber
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

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
     * @return ItemVariationMarketNumber
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return ItemVariationMarketNumber
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return ItemVariationMarketNumber
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
