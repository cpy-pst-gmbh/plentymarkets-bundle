<?php


namespace PM\PlentyMarketsBundle\Component\Response;

use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\Category\Category;

/**
 * Class CategoriesResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class CategoriesResponse extends PaginationResponse
{
    /**
     * @var Category[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Category\Category>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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