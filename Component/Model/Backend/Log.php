<?php

namespace PM\PlentyMarketsBundle\Component\Model\Backend;


/**
 * Entry of the plenty log. CreatedAt stays a string, plenty adds microseconds.
 */
class Log
{
    /** @var string|null */
    private ?string $identifier = null;

    /** @var string|null */
    private ?string $integration = null;

    /** @var string|null */
    private ?string $level = null;

    /** @var string|null */
    private ?string $code = null;

    /** @var string|null */
    private ?string $codeMessage = null;

    /** @var string|null */
    private ?string $callerFunction = null;

    /** @var string|null */
    private ?string $createdAt = null;

    /** @var string|null */
    private ?string $trace = null;

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(?string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getIntegration(): ?string
    {
        return $this->integration;
    }

    public function setIntegration(?string $integration): self
    {
        $this->integration = $integration;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCodeMessage(): ?string
    {
        return $this->codeMessage;
    }

    public function setCodeMessage(?string $codeMessage): self
    {
        $this->codeMessage = $codeMessage;

        return $this;
    }

    public function getCallerFunction(): ?string
    {
        return $this->callerFunction;
    }

    public function setCallerFunction(?string $callerFunction): self
    {
        $this->callerFunction = $callerFunction;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTrace(): ?string
    {
        return $this->trace;
    }

    public function setTrace(?string $trace): self
    {
        $this->trace = $trace;

        return $this;
    }
}
