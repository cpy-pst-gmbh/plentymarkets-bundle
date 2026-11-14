<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;

class ItemVariationBarcode
{
    /** @var int|null */
    private ?int $barcodeId = null;

    /** @var int|null */
    private ?int $variationId = null;

    /** @var string|null */
    private ?string $code = null;

    /** @var \DateTime|null */
    private ?DateTime $createdAt = null;

    public function getBarcodeId(): ?int
    {
        return $this->barcodeId;
    }

    public function setBarcodeId(?int $barcodeId): ItemVariationBarcode
    {
        $this->barcodeId = $barcodeId;

        return $this;
    }

    public function getVariationId(): ?int
    {
        return $this->variationId;
    }

    public function setVariationId(?int $variationId): ItemVariationBarcode
    {
        $this->variationId = $variationId;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): ItemVariationBarcode
    {
        $this->code = $code;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): ItemVariationBarcode
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}