<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 11:32
 */

namespace PM\PlentyMarketsBundle\Component\Response;

use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\Item\Manufacturer;

/**
 * Class ItemsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
#[JMS\ExclusionPolicy('ALL')]
class ManufacturersResponse extends PaginationResponse
{
    /**
     * @var Manufacturer[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Item\Manufacturer>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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