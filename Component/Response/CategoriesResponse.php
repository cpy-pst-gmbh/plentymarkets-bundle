<?php


namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Category\Category;

/**
 * Class CategoriesResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class CategoriesResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Category\Category> */
    private array $entries = [];

    /**
     * @return Category[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param Category[] $entries
     *
     * @return CategoriesResponse
     */
    public function setEntries(array $entries): self
    {
        $this->entries = $entries;

        return $this;
    }
}