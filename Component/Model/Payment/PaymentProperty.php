<?php

namespace PM\PlentyMarketsBundle\Component\Model\Payment;

/**
 * Property of a payment: transaction ID, booking text, sender and so on, by type.
 */
class PaymentProperty
{
    public const TYPE_TRANSACTION_ID = 1;
    public const TYPE_REFERENCE_ID = 2;
    public const TYPE_BOOKING_TEXT = 3;
    public const TYPE_SENDER_NAME = 11;
    public const TYPE_SENDER_IBAN = 18;
    public const TYPE_SENDER_BIC = 19;
    public const TYPE_REFERENCE_TEXT = 22;

    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $paymentId = null;

    /** @var int|null */
    private ?int $typeId = null;

    /** @var string|null */
    private ?string $value = null;

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

    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    public function setTypeId(?int $typeId): self
    {
        $this->typeId = $typeId;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
