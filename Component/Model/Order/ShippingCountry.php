<?php

namespace PM\PlentyMarketsBundle\Component\Model\Order;

/** A country of plentymarkets, as GET orders/shipping/countries lists it. */
class ShippingCountry
{
    private ?int $id = null;

    private ?string $name = null;

    private ?string $isoCode2 = null;

    private ?string $isoCode3 = null;

    private ?bool $active = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIsoCode2(): ?string
    {
        return $this->isoCode2;
    }

    public function setIsoCode2(?string $isoCode2): static
    {
        $this->isoCode2 = $isoCode2;

        return $this;
    }

    public function getIsoCode3(): ?string
    {
        return $this->isoCode3;
    }

    public function setIsoCode3(?string $isoCode3): static
    {
        $this->isoCode3 = $isoCode3;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
