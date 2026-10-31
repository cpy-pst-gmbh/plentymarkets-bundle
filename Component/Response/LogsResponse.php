<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Model\Backend\Log;

#[JMS\ExclusionPolicy('ALL')]
class LogsResponse extends PaginationResponse
{
    /**
     * @var Log[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Backend\Log>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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
