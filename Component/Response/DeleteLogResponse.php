<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use PM\PlentyMarketsBundle\Component\Model\Backend\DeleteLog;

class DeleteLogResponse extends PaginationResponse
{
    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Backend\DeleteLog> */
    private array $entries = [];

    /**
     * @return DeleteLog[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param DeleteLog[] $entries
     */
    public function setEntries(array $entries): self
    {
        $this->entries = $entries;

        return $this;
    }
}
