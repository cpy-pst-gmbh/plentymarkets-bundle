<?php


namespace PM\PlentyMarketsBundle\Component\Model\Category;


/**
 * Class CategoryDetail
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Category
 *
 * @TODO    Include all properties
 */
class CategoryDetail
{

    /** @var int|null */
    private ?int $categoryId = null;

    /** @var string|null */
    private ?string $lang = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var int|null */
    private ?int $plentyId = null;

    /** @var int|null */
    private ?int $position = null;

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return CategoryDetail
     */
    public function setCategoryId(int $categoryId): CategoryDetail
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @return CategoryDetail
     */
    public function setLang(string $lang): CategoryDetail
    {
        $this->lang = $lang;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return CategoryDetail
     */
    public function setName(string $name): CategoryDetail
    {
        $this->name = $name;

        return $this;
    }

    public function getPlentyId(): ?int
    {
        return $this->plentyId;
    }

    public function setPlentyId(?int $plentyId): CategoryDetail
    {
        $this->plentyId = $plentyId;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): CategoryDetail
    {
        $this->position = $position;

        return $this;
    }
}