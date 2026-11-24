<?php

namespace PM\PlentyMarketsBundle\Component\Model\Listing;

use DateTime;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

/** A listing on a market as it ran, from GET listings/markets/histories. The dates come without zone. */
class ListingMarketHistory
{
    private ?int $id = null;

    private ?int $listingMarketId = null;

    private ?float $referrerId = null;

    private ?string $externalId = null;

    private ?float $quantity = null;

    private ?float $quantityRemain = null;

    private ?float $quantitySold = null;

    private ?float $quantitySoldDelta = null;

    private ?int $statusId = null;

    private ?float $price = null;

    private ?string $sku = null;

    private ?int $hasStockReservationForEbay = null;

    private ?string $currency = null;

    #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    private ?DateTime $createdAt = null;

    #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    private ?DateTime $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getListingMarketId(): ?int
    {
        return $this->listingMarketId;
    }

    public function setListingMarketId(?int $listingMarketId): static
    {
        $this->listingMarketId = $listingMarketId;

        return $this;
    }

    public function getReferrerId(): ?float
    {
        return $this->referrerId;
    }

    public function setReferrerId(?float $referrerId): static
    {
        $this->referrerId = $referrerId;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantityRemain(): ?float
    {
        return $this->quantityRemain;
    }

    public function setQuantityRemain(?float $quantityRemain): static
    {
        $this->quantityRemain = $quantityRemain;

        return $this;
    }

    public function getQuantitySold(): ?float
    {
        return $this->quantitySold;
    }

    public function setQuantitySold(?float $quantitySold): static
    {
        $this->quantitySold = $quantitySold;

        return $this;
    }

    public function getQuantitySoldDelta(): ?float
    {
        return $this->quantitySoldDelta;
    }

    public function setQuantitySoldDelta(?float $quantitySoldDelta): static
    {
        $this->quantitySoldDelta = $quantitySoldDelta;

        return $this;
    }

    public function getStatusId(): ?int
    {
        return $this->statusId;
    }

    public function setStatusId(?int $statusId): static
    {
        $this->statusId = $statusId;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(?string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getHasStockReservationForEbay(): ?int
    {
        return $this->hasStockReservationForEbay;
    }

    public function setHasStockReservationForEbay(?int $hasStockReservationForEbay): static
    {
        $this->hasStockReservationForEbay = $hasStockReservationForEbay;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
