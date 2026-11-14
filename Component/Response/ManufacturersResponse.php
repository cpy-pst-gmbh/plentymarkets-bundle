<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 11:32
 */

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Item\Manufacturer;

/**
 * Class ItemsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class ManufacturersResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\Manufacturer> */
    private array $entries = [];

    /**
     * @return Manufacturer[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param Manufacturer[] $entries
     *
     * @return ItemsResponse
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

}