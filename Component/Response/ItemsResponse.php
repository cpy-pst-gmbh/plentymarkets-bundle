<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 11:32
 */

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Item\Item;

/**
 * Class ItemsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class ItemsResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\Item> */
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