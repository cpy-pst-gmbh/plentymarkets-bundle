<?php

namespace PM\PlentyMarketsBundle\Component\Model\Account;

use JMS\Serializer\Annotation as JMS;

#[JMS\ExclusionPolicy('ALL')]
class ContactAllowedMethodOfPayment
{
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $methodOfPaymentId = null;

    #[JMS\Type('boolean')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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
