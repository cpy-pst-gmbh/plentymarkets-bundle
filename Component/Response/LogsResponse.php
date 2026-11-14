<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Backend\Log;

class LogsResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Backend\Log> */
    private array $entries = [];

    /**
     * @return Log[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param Log[] $entries
     */
    public function setEntries(array $entries): self
    {
        $this->entries = $entries;

        return $this;
    }
}
