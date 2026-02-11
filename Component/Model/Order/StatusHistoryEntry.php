<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 12.02.2018
 * Time: 10:11
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use DateTimeInterface;
use JMS\Serializer\Annotation as JMS;

#[JMS\ExclusionPolicy('ALL')]
class StatusHistoryEntry
{
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $id;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $orderId;

    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $statusId;

    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $createdAt;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $userId = null;

    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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