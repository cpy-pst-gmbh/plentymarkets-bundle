<?php

namespace PM\PlentyMarketsBundle\Component\Model\Fulfilment;


class PicklistFilterOptions
{
    /** @var array */
    private array $orderIds = [];

    public function getOrderIds(): array
    {
        return $this->orderIds;
    }

}