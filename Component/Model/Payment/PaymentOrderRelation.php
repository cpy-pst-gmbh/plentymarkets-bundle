<?php

namespace PM\PlentyMarketsBundle\Component\Model\Payment;

/**
 * Link of a payment to an order. AssignedAt stays a string, as plenty sends it.
 */
class PaymentOrderRelation
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $paymentId = null;

    /** @var int|null */
    private ?int $orderId = null;

    /** @var string|null */
    private ?string $assignedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPaymentId(): ?int
    {
        return $this->paymentId;
    }

    public function setPaymentId(?int $paymentId): self
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(?int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getAssignedAt(): ?string
    {
        return $this->assignedAt;
    }

    public function setAssignedAt(?string $assignedAt): self
    {
        $this->assignedAt = $assignedAt;

        return $this;
    }
}
