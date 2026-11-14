<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 30.11.2018
 * Time: 14:50
 */

namespace PM\PlentyMarketsBundle\Component\Response;


use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\Item\Barcode;

/**
 * Class ItemsBarcodesResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class ItemsBarcodesResponse extends PaginationResponse
{
    /**
     * @var Barcode[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Item\Barcode>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private array $entries = [];

    /**
     * @return Barcode[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param Barcode[] $entries
     *
     * @return ItemsBarcodesResponse
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

}