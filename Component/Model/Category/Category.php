<?php


namespace PM\PlentyMarketsBundle\Component\Model\Category;

use LogicException;

/**
 * Class Category
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Category
 *
 * @TODO    Include all properties
 */
class Category
{
    public const TYPE_ITEM = 'item';

    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $parentCategoryId = null;

    /** @var int|null */
    private ?int $level = null;

    /** @var string|null */
    private ?string $type = null;


    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Category\CategoryDetail>|null */
    private ?array $details = null;

    /**
     * Only filled when requested with "with=clients"
     *
     * @var list<\PM\PlentyMarketsBundle\Component\Model\Category\CategoryClient>|null
     */
    private ?array $clients = null;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Category
     */
    public function setId(int $id): Category
    {
        $this->id = $id;

        return $this;
    }

    public function getParentCategoryId(): ?int
    {
        return $this->parentCategoryId;
    }

    /**
     * @return Category
     */
    public function setParentCategoryId(?int $parentCategoryId): Category
    {
        $this->parentCategoryId = $parentCategoryId;

        return $this;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @return Category
     */
    public function setLevel(int $level): Category
    {
        $this->level = $level;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return Category
     */
    public function setType(string $type): Category
    {
        $this->type = $type;

        return $this;
    }


    /**
     * @return array|CategoryDetail[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param array|CategoryDetail[] $details
     *
     * @return Category
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return CategoryClient[]|null
     */
    public function getClients(): ?array
    {
        return $this->clients;
    }

    /**
     * @param CategoryClient[]|null $clients
     */
    public function setClients(?array $clients): Category
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * Get Detail
     *
     *
     * @return CategoryDetail
     */
    public function getDetailByLanguage(string $language = 'de'): CategoryDetail
    {
        foreach ($this->getDetails() as $detail) {
            if ($language === $detail->getLang()) {
                return $detail;
            }
        }

        throw new LogicException(sprintf('Categors %d has no details for %s', $this->getId(), $language));
    }
}