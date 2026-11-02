<?php

namespace PM\PlentyMarketsBundle\Component\Model\Listing;

use JMS\Serializer\Annotation as JMS;

/**
 * Market listing of a variation, listings/markets. The id is the listing id at the market.
 */
#[JMS\ExclusionPolicy('ALL')]
class ListingMarket
{
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $id = null;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $listingId = null;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?int $variationId = null;

    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?float $referrerId = null;

    #[JMS\Type('boolean')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?bool $enabled = null;

    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
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
