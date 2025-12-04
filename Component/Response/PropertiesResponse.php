<?php

namespace PM\PlentyMarketsBundle\Component\Response;

use AppBundle\Entity\Property\Property;
use JMS\Serializer\Annotation as JMS;

#[JMS\ExclusionPolicy('ALL')]
class PropertiesResponse extends PaginationResponse
{

    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Property\Property>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private array $entries = [];

    /**
     * @return Property[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    public function setEntries(array $entries): static
    {
        $this->entries = $entries;

        return $this;
    }


}
