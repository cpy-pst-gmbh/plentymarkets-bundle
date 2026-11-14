<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 11:32
 */

namespace PM\PlentyMarketsBundle\Component\Response;

use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\Item\Item;

/**
 * Class ItemsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
#[JMS\ExclusionPolicy('ALL')]
class ItemsResponse extends PaginationResponse
{
    /**
     * @var Item[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Item\Item>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private array $entries = [];

    /**
     * @return Item[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param Item[] $entries
     *
     * @return ItemsResponse
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

}