<?php

namespace PM\PlentyMarketsBundle\Component\Model\Fulfilment;

use function array_map;
use function array_values;

class PicklistFilterOptions
{
    /**
     * As plentymarkets sends them: the order IDs are strings. The serializer assigns the values of
     * an array without converting them, so getOrderIds() does.
     *
     * @var array<array-key, int|string>
     */
    private array $orderIds = [];

    /** @return list<int> */
    public function getOrderIds(): array
    {
        return array_values(array_map(intval(...), $this->orderIds));
    }
}
