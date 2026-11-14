<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Client (shop) a variation is linked to
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationClient
{
    /** @var int|null */
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
