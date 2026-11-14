<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Tag on a variation
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationTag
{
    /** @var int|null */
    private ?int $tagId = null;

    public function getTagId(): ?int
    {
        return $this->tagId;
    }

    public function setTagId(?int $tagId): ItemVariationTag
    {
        $this->tagId = $tagId;

        return $this;
    }
}
