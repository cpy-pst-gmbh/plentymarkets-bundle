<?php

namespace PM\PlentyMarketsBundle\Component\Model\Fulfilment;

use DateTimeInterface;

class Picklist
{
    /** @var int */
    private readonly int $id;

    /** @var \DateTime */
    private readonly DateTimeInterface $createdAt;

    /** @var \DateTime|null */
    private ?DateTimeInterface $processDate = null;

    /** @var \DateTime|null */
    private ?DateTimeInterface $doneDate = null;

    /** @var int */
    private readonly int $ownerId;

    /** @var int|null */
    private ?int $processUserId = null;

    /** @var string */
    private string $processState = '';

    /** @var \PicklistFilterOptions */
    private readonly PicklistFilterOptions $filterOptions;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getProcessDate(): ?DateTimeInterface
    {
        return $this->processDate;
    }

    public function getDoneDate(): ?DateTimeInterface
    {
        return $this->doneDate;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getProcessUserId(): ?int
    {
        return $this->processUserId;
    }

    public function getProcessState(): string
    {
        return $this->processState;
    }

    public function getFilterOptions(): PicklistFilterOptions
    {
        return $this->filterOptions;
    }

}