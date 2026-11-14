<?php


namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Class ItemVariationMarket
 *
 * Marktplatz-Verknuepfung einer Variante, with=variationMarkets
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationMarket
{
    /** @var int|null */
    private ?int $variationId = null;

    /** @var float|null */
    private ?float $marketId = null;

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
     * @return ItemVariationMarket
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;

        return $this;
    }

    /**
     * @return float
     */
    public function getMarketId()
    {
        return $this->marketId;
    }

    /**
     * @param float $marketId
     *
     * @return ItemVariationMarket
     */
    public function setMarketId($marketId)
    {
        $this->marketId = $marketId;

        return $this;
    }
}
