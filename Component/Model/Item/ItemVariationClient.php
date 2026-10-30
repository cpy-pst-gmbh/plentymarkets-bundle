<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use JMS\Serializer\Annotation as JMS;

/**
 * Client (shop) a variation is linked to
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
#[JMS\ExclusionPolicy('ALL')]
class ItemVariationClient
{
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $plentyId = null;

    public function getPlentyId(): ?int
    {
        return $this->plentyId;
    }

    public function setPlentyId(?int $plentyId): ItemVariationClient
    {
        $this->plentyId = $plentyId;

        return $this;
    }
}
