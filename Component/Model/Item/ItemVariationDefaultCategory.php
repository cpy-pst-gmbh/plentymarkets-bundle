<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use JMS\Serializer\Annotation as JMS;

/**
 * Default category of a variation for a client
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
#[JMS\ExclusionPolicy('ALL')]
class ItemVariationDefaultCategory
{
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $plentyId = null;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $branchId = null;

    public function getPlentyId(): ?int
    {
        return $this->plentyId;
    }

    public function setPlentyId(?int $plentyId): ItemVariationDefaultCategory
    {
        $this->plentyId = $plentyId;

        return $this;
    }

    public function getBranchId(): ?int
    {
        return $this->branchId;
    }

    public function setBranchId(?int $branchId): ItemVariationDefaultCategory
    {
        $this->branchId = $branchId;

        return $this;
    }
}
