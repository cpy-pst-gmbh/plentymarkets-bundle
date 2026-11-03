<?php


namespace PM\PlentyMarketsBundle\Component\Model\Item;

use JMS\Serializer\Annotation as JMS;

/**
 * Class ItemVariationMarket
 *
 * Marktplatz-Verknuepfung einer Variante, with=variationMarkets
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
#[JMS\ExclusionPolicy('ALL')]
class ItemVariationMarket
{
    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $variationId;

    /**
     * @var float
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $marketId;

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
