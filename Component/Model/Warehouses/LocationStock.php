<?php


namespace PM\PlentyMarketsBundle\Component\Model\Warehouses;

use DateTime;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * Class LocationStock
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Warehouses
 */
class LocationStock
{

    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    #[SerializedName('storage_location')]
    private ?int $storageLocation = null;

    /** @var int|null */
    #[SerializedName('item_id')]
    private ?int $itemId = null;

    /** @var int|null */
    #[SerializedName('attribute_value_set')]
    private ?int $attributeValueSet = null;

    /** @var int|null */
    #[SerializedName('warehouse_id')]
    private ?int $warehouseId = null;

    /** @var float|null */
    private ?float $quantity = null;

    /** @var float|null */
    private ?float $reserved = null;

    /** @var int|null */
    #[SerializedName('variation_id')]
    private ?int $variationId = null;

    /** @var \DateTime|null */
    #[SerializedName('last_update')]
    #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'])]
    private ?\DateTime $lastUpdate = null;

    /** @var int|null */
    private ?int $batchBestBeforeDateId = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var string|null */
    private ?string $fullLabel = null;

    /** @var int|null */
    private ?int $warehouseLocationLevel = null;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return LocationStock
     */
    public function setId(int $id): LocationStock
    {
        $this->id = $id;

        return $this;
    }

    public function getStorageLocation(): int
    {
        return $this->storageLocation;
    }

    /**
     * @return LocationStock
     */
    public function setStorageLocation(int $storageLocation): LocationStock
    {
        $this->storageLocation = $storageLocation;

        return $this;
    }

    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @return LocationStock
     */
    public function setItemId(int $itemId): LocationStock
    {
        $this->itemId = $itemId;

        return $this;
    }

    public function getAttributeValueSet(): int
    {
        return $this->attributeValueSet;
    }

    /**
     * @return LocationStock
     */
    public function setAttributeValueSet(int $attributeValueSet): LocationStock
    {
        $this->attributeValueSet = $attributeValueSet;

        return $this;
    }

    public function getWarehouseId(): int
    {
        return $this->warehouseId;
    }

    /**
     * @return LocationStock
     */
    public function setWarehouseId(int $warehouseId): LocationStock
    {
        $this->warehouseId = $warehouseId;

        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @return LocationStock
     */
    public function setQuantity(float $quantity): LocationStock
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getReserved(): float
    {
        return $this->reserved;
    }

    /**
     * @return LocationStock
     */
    public function setReserved(float $reserved): LocationStock
    {
        $this->reserved = $reserved;

        return $this;
    }

    public function getVariationId(): int
    {
        return $this->variationId;
    }

    /**
     * @return LocationStock
     */
    public function setVariationId(int $variationId): LocationStock
    {
        $this->variationId = $variationId;

        return $this;
    }

    public function getLastUpdate(): DateTime
    {
        return $this->lastUpdate;
    }

    /**
     * @return LocationStock
     */
    public function setLastUpdate(DateTime $lastUpdate): LocationStock
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    public function getBatchBestBeforeDateId(): int
    {
        return $this->batchBestBeforeDateId;
    }

    /**
     * @return LocationStock
     */
    public function setBatchBestBeforeDateId(int $batchBestBeforeDateId): LocationStock
    {
        $this->batchBestBeforeDateId = $batchBestBeforeDateId;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return LocationStock
     */
    public function setName(string $name): LocationStock
    {
        $this->name = $name;

        return $this;
    }

    public function getFullLabel(): string
    {
        return $this->fullLabel;
    }

    /**
     * @return LocationStock
     */
    public function setFullLabel(string $fullLabel): LocationStock
    {
        $this->fullLabel = $fullLabel;

        return $this;
    }

    public function getWarehouseLocationLevel(): ?int
    {
        return $this->warehouseLocationLevel;
    }

    /**
     * @return LocationStock
     */
    public function setWarehouseLocationLevel(?int $warehouseLocationLevel): LocationStock
    {
        $this->warehouseLocationLevel = $warehouseLocationLevel;

        return $this;
    }

}