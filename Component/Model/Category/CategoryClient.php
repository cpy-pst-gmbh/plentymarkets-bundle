<?php

namespace PM\PlentyMarketsBundle\Component\Model\Category;

use JMS\Serializer\Annotation as JMS;

/**
 * Client (shop) a category is linked to
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Category
 */
#[JMS\ExclusionPolicy('ALL')]
class CategoryClient
{
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $categoryId = null;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $plentyId = null;

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): CategoryClient
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getPlentyId(): ?int
    {
        return $this->plentyId;
    }

    public function setPlentyId(?int $plentyId): CategoryClient
    {
        $this->plentyId = $plentyId;

        return $this;
    }
}
