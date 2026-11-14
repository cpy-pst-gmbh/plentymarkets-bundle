<?php


namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Class ItemVariationSalesPrice
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationCategory
{
    /** @var int|null */
    private ?int $variationId = null;

    /** @var int|null */
    private ?int $categoryId = null;

    /** @var int|null */
    private ?int $position = null;

    /** @var bool|null */
    private ?bool $isNeckermannPrimary = null;

    public function getVariationId(): int
    {
        return $this->variationId;
    }

    /**
     * @return ItemVariationCategory
     */
    public function setVariationId(int $variationId): ItemVariationCategory
    {
        $this->variationId = $variationId;

        return $this;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return ItemVariationCategory
     */
    public function setCategoryId(int $categoryId): ItemVariationCategory
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return ItemVariationCategory
     */
    public function setPosition(int $position): ItemVariationCategory
    {
        $this->position = $position;

        return $this;
    }

    public function isNeckermannPrimary(): bool
    {
        return $this->isNeckermannPrimary;
    }

    /**
     * @return ItemVariationCategory
     */
    public function setIsNeckermannPrimary(bool $isNeckermannPrimary): ItemVariationCategory
    {
        $this->isNeckermannPrimary = $isNeckermannPrimary;

        return $this;
    }

}