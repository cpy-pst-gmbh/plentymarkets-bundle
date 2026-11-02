<?php


namespace PM\PlentyMarketsBundle\Component\Model\Category;

use JMS\Serializer\Annotation as JMS;

/**
 * Class CategoryDetail
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Category
 *
 * @TODO    Include all properties
 */
#[JMS\ExclusionPolicy('ALL')]
class CategoryDetail
{

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $categoryId;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $lang;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $name;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $plentyId = null;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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