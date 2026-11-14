<?php

namespace PM\PlentyMarketsBundle\Component\Model\Category;


/**
 * Client (shop) a category is linked to
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Category
 */
class CategoryClient
{
    /** @var int|null */
    private ?int $categoryId = null;

    /** @var int|null */
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
