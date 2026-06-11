<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;
use JMS\Serializer\Annotation as JMS;

#[JMS\ExclusionPolicy('ALL')]
class ItemVariationSku
{
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private int $id;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private int $variationId;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private int $marketId;

    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private int $accountId;

    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private string $initialSku = '';

    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private string $sku = '';

    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private string $parentSku = '';

    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private string $status = '';

    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private string $additionalInformation = '';

    #[JMS\Type('boolean')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private bool $isActive = false;

    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private DateTime $createdAt;

    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?DateTime $updatedAt = null;

    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?DateTime $exportedAt = null;

    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?DateTime $stockUpdatedAt = null;

    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?DateTime $deletedAt = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): ItemVariationSku
    {
        $this->id = $id;

        return $this;
    }

    public function getVariationId(): int
    {
        return $this->variationId;
    }

    public function setVariationId(int $variationId): ItemVariationSku
    {
        $this->variationId = $variationId;

        return $this;
    }

    public function getMarketId(): int
    {
        return $this->marketId;
    }

    public function setMarketId(int $marketId): ItemVariationSku
    {
        $this->marketId = $marketId;

        return $this;
    }

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId): ItemVariationSku
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getInitialSku(): string
    {
        return $this->initialSku;
    }

    public function setInitialSku(string $initialSku): ItemVariationSku
    {
        $this->initialSku = $initialSku;

        return $this;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): ItemVariationSku
    {
        $this->sku = $sku;

        return $this;
    }

    public function getParentSku(): string
    {
        return $this->parentSku;
    }

    public function setParentSku(string $parentSku): ItemVariationSku
    {
        $this->parentSku = $parentSku;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): ItemVariationSku
    {
        $this->status = $status;

        return $this;
    }

    public function getAdditionalInformation(): string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(string $additionalInformation): ItemVariationSku
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): ItemVariationSku
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): ItemVariationSku
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): ItemVariationSku
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getExportedAt(): ?DateTime
    {
        return $this->exportedAt;
    }

    public function setExportedAt(?DateTime $exportedAt): ItemVariationSku
    {
        $this->exportedAt = $exportedAt;

        return $this;
    }

    public function getStockUpdatedAt(): ?DateTime
    {
        return $this->stockUpdatedAt;
    }

    public function setStockUpdatedAt(?DateTime $stockUpdatedAt): ItemVariationSku
    {
        $this->stockUpdatedAt = $stockUpdatedAt;

        return $this;
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt): ItemVariationSku
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
