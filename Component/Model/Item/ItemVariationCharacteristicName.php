<?php


namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Class ItemVariationCharacteristicName
 *
 * Text eines Merkmals vom Typ Text je Sprache
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationCharacteristicName
{
    /** @var string|null */
    private ?string $lang = null;

    /** @var string|null */
    private ?string $value = null;

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     *
     * @return ItemVariationCharacteristicName
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

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
     * @return ItemVariationCharacteristicName
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
