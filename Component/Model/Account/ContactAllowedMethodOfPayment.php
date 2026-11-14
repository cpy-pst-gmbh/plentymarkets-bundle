<?php

namespace PM\PlentyMarketsBundle\Component\Model\Account;


class ContactAllowedMethodOfPayment
{
    /** @var int|null */
    private ?int $methodOfPaymentId = null;

    /** @var bool|null */
    private ?bool $allowed = null;

    public function getMethodOfPaymentId(): ?int
    {
        return $this->methodOfPaymentId;
    }

    public function setMethodOfPaymentId(?int $methodOfPaymentId): self
    {
        $this->methodOfPaymentId = $methodOfPaymentId;

        return $this;
    }

    public function isAllowed(): ?bool
    {
        return $this->allowed;
    }

    public function setAllowed(?bool $allowed): self
    {
        $this->allowed = $allowed;

        return $this;
    }
}
