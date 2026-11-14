<?php

namespace PM\PlentyMarketsBundle\Component\Model\Listing;


/**
 * Market listing of a variation, listings/markets. The id is the listing id at the market.
 */
class ListingMarket
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $listingId = null;

    /** @var int|null */
    private ?int $variationId = null;

    /** @var float|null */
    private ?float $referrerId = null;

    /** @var bool|null */
    private ?bool $enabled = null;

    /** @var string|null */
    private ?string $verified = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getListingId(): ?int
    {
        return $this->listingId;
    }

    public function setListingId(?int $listingId): self
    {
        $this->listingId = $listingId;

        return $this;
    }

    public function getVariationId(): ?int
    {
        return $this->variationId;
    }

    public function setVariationId(?int $variationId): self
    {
        $this->variationId = $variationId;

        return $this;
    }

    public function getReferrerId(): ?float
    {
        return $this->referrerId;
    }

    public function setReferrerId(?float $referrerId): self
    {
        $this->referrerId = $referrerId;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getVerified(): ?string
    {
        return $this->verified;
    }

    public function setVerified(?string $verified): self
    {
        $this->verified = $verified;

        return $this;
    }
}
