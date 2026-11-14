<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.07.2017
 * Time: 11:32
 */

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Account\Contact;
use PM\PlentyMarketsBundle\Component\Model\Item\Item;

/**
 * Class ItemsResponse
 *
 * @package PM\PlentyMarketsBundle\Component\Response
 */
class ContactsResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Account\Contact> */
    private array $entries = [];

    /**
     * @return Contact[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param Contact[] $entries
     *
     * @return ContactsResponse
     */
    public function setEntries(array $entries): self
    {
        $this->entries = $entries;

        return $this;
    }

}