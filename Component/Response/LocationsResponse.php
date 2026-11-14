<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 21.11.2018
 * Time: 11:04
 */

namespace PM\PlentyMarketsBundle\Component\Response;

use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\Warehouses\Location;

/**
 * Class LocationsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
#[JMS\ExclusionPolicy('ALL')]
class LocationsResponse extends PaginationResponse
{
    /**
     * @var Location[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Warehouses\Location>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private array $entries = [];

    /**
     * @return Location[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param Location[] $entries
     *
     * @return LocationsResponse
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

}