<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.02.2018
 * Time: 10:11
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use DateTimeInterface;

class StatusHistoryEntry
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $orderId = null;

    /** @var float|null */
    private ?float $statusId = null;

    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var int|null */
    private ?int $userId = null;

    /** @var string|null */
    private ?string $procedureText = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getStatusId(): float
    {
        return $this->statusId;
    }

    public function setStatusId(float $statusId): self
    {
        $this->statusId = $statusId;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getProcedureText(): ?string
    {
        return $this->procedureText;
    }

    public function setProcedureText(?string $procedureText): self
    {
        $this->procedureText = $procedureText;

        return $this;
    }

}