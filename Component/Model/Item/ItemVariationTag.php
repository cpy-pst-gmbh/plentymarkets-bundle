<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use JMS\Serializer\Annotation as JMS;

/**
 * Tag on a variation
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
#[JMS\ExclusionPolicy('ALL')]
class ItemVariationTag
{
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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
