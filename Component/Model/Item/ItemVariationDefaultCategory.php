<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Default category of a variation for a client
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationDefaultCategory
{
    /** @var int|null */
    private ?int $plentyId = null;

    /** @var int|null */
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
