<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;
use Symfony\Component\Serializer\Attribute\SerializedName;
use PM\PlentyMarketsBundle\Component\Model\Property\Relation;

class ItemVariation
{
    public const BUNDLE_TYPE_BUNDLE = 'bundle';
    public const BUNDLE_TYPE_ITEM = 'bundle_item';

    /** @var int|null */
    private ?int $id = null;

    /** @var bool|null */
    private ?bool $isMain = null;

    /** @var int|null */
    private ?int $mainVariationId = null;

    /** @var int|null */
    private ?int $itemId = null;

    /** @var int|null */
    private ?int $categoryVariationId = null;

    /** @var int|null */
    private ?int $marketVariationId = null;

    /** @var int|null */
    private ?int $clientVariationId = null;

    /** @var int|null */
    private ?int $salesPriceVariationId = null;

    /** @var int|null */
    private ?int $supplierVariationId = null;

    /** @var int|null */
    private ?int $warehouseVariationId = null;

    /** @var int|null */
    private ?int $position = null;

    /** @var bool|null */
    private ?bool $isActive = null;

    /** @var string|null */
    private ?string $number = null;

    /** @var string|null */
    private ?string $model = null;

    /** @var string|null */
    private ?string $externalId = null;

    /** @var int|null */
    private ?int $availability = null;

    /** @var \DateTime|null */
    private ?\DateTime $estimatedAvailableAt = null;

    /** @var float|null */
    private ?float $purchasePrice = null;

    /** @var float|null */
    private ?float $movingAveragePrice = null;

    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

    /** @var \DateTime|null */
    private ?\DateTime $relatedUpdatedAt = null;

    /** @var int|null */
    private ?int $priceCalculationId = null;

    /** @var string|null */
    private ?string $picking = null;

    /** @var int|null */
    private ?int $stockLimitation = null;

    /** @var bool|null */
    private ?bool $isVisibleIfNetStockIsPositive = null;

    /** @var bool|null */
    private ?bool $isInvisibleIfNetStockIsNotPositive = null;

    /** @var bool|null */
    private ?bool $isVisibleInListIfNetStockIsPositive = null;

    /** @var bool|null */
    private ?bool $isInvisibleInListIfNetStockIsNotPositive = null;

    /** @var bool|null */
    private ?bool $isAvailableIfNetStockIsPositive = null;

    /** @var bool|null */
    private ?bool $isUnavailableIfNetStockIsNotPositive = null;

    /** @var int|null */
    private ?int $mainWarehouseId = null;

    /** @var int|null */
    private ?int $maximumOrderQuantity = null;

    /** @var int|null */
    private ?int $minimumOrderQuantity = null;

    /** @var int|null */
    private ?int $intervalOrderQuantity = null;

    /** @var string|null */
    private ?string $availableUntil = null;

    /** @var \DateTime|null */
    private ?\DateTime $releasedAt = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var int|null */
    private ?int $weightG = null;

    /** @var int|null */
    private ?int $weightNetG = null;

    /** @var int|null */
    private ?int $widthMM = null;

    /** @var int|null */
    private ?int $lengthMM = null;

    /** @var int|null */
    private ?int $heightMM = null;

    /** @var float|null */
    private ?float $extraShippingCharge1 = null;

    /** @var float|null */
    private ?float $extraShippingCharge2 = null;

    /** @var int|null */
    private ?int $unitsContained = null;

    /** @var int|null */
    private ?int $palletTypeId = null;

    /** @var int|null */
    private ?int $packingUnits = null;

    /** @var int|null */
    private ?int $packingUnitTypeId = null;

    /** @var float|null */
    private ?float $transportationCosts = null;

    /** @var float|null */
    private ?float $storageCosts = null;

    /** @var float|null */
    private ?float $customs = null;

    /** @var float|null */
    private ?float $operatingCosts = null;

    /** @var int|null */
    private ?int $vatId = null;

    /** @var string|null */
    private ?string $bundleType = null;

    /** @var int|null */
    private ?int $automaticClientVisibility = null;

    /** @var bool|null */
    private ?bool $isHiddenInCategoryList = null;

    /** @var float|null */
    private ?float $defaultShippingCosts = null;

    /** @var bool|null */
    private ?bool $mayShowUnitPrice = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemImage> */
    private array $images = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemImage> */
    private array $itemImages = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationBarcode> */
    private array $variationBarcodes = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationCategory> */
    private array $variationCategories = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationSalesPrice> */
    private array $variationSalesPrices = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationMarket> */
    private array $variationMarkets = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationMarketNumber> */
    private array $marketItemNumbers = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationBundleComponent> */
    private array $variationBundleComponents = [];

    /**
     * Merkmale (alte Eigenschaften), with=variationProperties
     *
     * @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationCharacteristic>
     */
    #[SerializedName('variationProperties')]
    private array $variationCharacteristics = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationSku> */
    private array $variationSkus = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationSupplier> */
    private array $variationSuppliers = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Property\Relation> */
    private array $properties = [];

    /**
     * Tags, with=tags. Null when not requested.
     *
     * @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationTag>|null
     */
    private ?array $tags = null;

    /**
     * Clients, with=variationClients. Null when not requested.
     *
     * @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationClient>|null
     */
    private ?array $variationClients = null;

    /**
     * Default categories, with=variationDefaultCategory. Null when not requested.
     *
     * @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationDefaultCategory>|null
     */
    private ?array $variationDefaultCategory = null;

    /**
     * Stock per warehouse, with=stock. Null when not requested.
     *
     * @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationStock>|null
     */
    private ?array $stock = null;

    /**
     * Reorder levels and more per warehouse, with=variationWarehouses. Null when not requested.
     *
     * @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationWarehouse>|null
     */
    private ?array $variationWarehouses = null;

    /**
     * Unit and content, with=unit. Null when not requested.
     * @var \PM\PlentyMarketsBundle\Component\Model\Item\ItemVariationUnit|null
     */
    private ?ItemVariationUnit $unit = null;

    /**
     * Item, with=item. Null when not requested.
     * @var \PM\PlentyMarketsBundle\Component\Model\Item\Item|null
     */
    private ?Item $item = null;

    /**
     * Customs tariff number, plenty keeps it at the variation. Writing the field of the item has no effect.
     * @var string|null
     */
    private ?string $customsTariffNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ItemVariation
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsMain()
    {
        return $this->isMain;
    }

    /**
     * @param bool $isMain
     *
     * @return ItemVariation
     */
    public function setIsMain($isMain)
    {
        $this->isMain = $isMain;

        return $this;
    }

    /**
     * @return int
     */
    public function getMainVariationId()
    {
        return $this->mainVariationId;
    }

    /**
     * @param int $mainVariationId
     *
     * @return ItemVariation
     */
    public function setMainVariationId($mainVariationId)
    {
        $this->mainVariationId = $mainVariationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     *
     * @return ItemVariation
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryVariationId()
    {
        return $this->categoryVariationId;
    }

    /**
     * @param int $categoryVariationId
     *
     * @return ItemVariation
     */
    public function setCategoryVariationId($categoryVariationId)
    {
        $this->categoryVariationId = $categoryVariationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getMarketVariationId()
    {
        return $this->marketVariationId;
    }

    /**
     * @param int $marketVariationId
     *
     * @return ItemVariation
     */
    public function setMarketVariationId($marketVariationId)
    {
        $this->marketVariationId = $marketVariationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getClientVariationId()
    {
        return $this->clientVariationId;
    }

    /**
     * @param int $clientVariationId
     *
     * @return ItemVariation
     */
    public function setClientVariationId($clientVariationId)
    {
        $this->clientVariationId = $clientVariationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSalesPriceVariationId()
    {
        return $this->salesPriceVariationId;
    }

    /**
     * @param int $salesPriceVariationId
     *
     * @return ItemVariation
     */
    public function setSalesPriceVariationId($salesPriceVariationId)
    {
        $this->salesPriceVariationId = $salesPriceVariationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSupplierVariationId()
    {
        return $this->supplierVariationId;
    }

    /**
     * @param int $supplierVariationId
     *
     * @return ItemVariation
     */
    public function setSupplierVariationId($supplierVariationId)
    {
        $this->supplierVariationId = $supplierVariationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getWarehouseVariationId()
    {
        return $this->warehouseVariationId;
    }

    /**
     * @param int $warehouseVariationId
     *
     * @return ItemVariation
     */
    public function setWarehouseVariationId($warehouseVariationId)
    {
        $this->warehouseVariationId = $warehouseVariationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return ItemVariation
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     *
     * @return ItemVariation
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     *
     * @return ItemVariation
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     *
     * @return ItemVariation
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     *
     * @return ItemVariation
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return int
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param int $availability
     *
     * @return ItemVariation
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEstimatedAvailableAt()
    {
        return $this->estimatedAvailableAt;
    }

    /**
     * @param DateTime $estimatedAvailableAt
     *
     * @return ItemVariation
     */
    public function setEstimatedAvailableAt($estimatedAvailableAt)
    {
        $this->estimatedAvailableAt = $estimatedAvailableAt;

        return $this;
    }

    /**
     * @return float
     */
    public function getPurchasePrice()
    {
        return $this->purchasePrice;
    }

    /**
     * @param float $purchasePrice
     *
     * @return ItemVariation
     */
    public function setPurchasePrice($purchasePrice)
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getMovingAveragePrice(): ?float
    {
        return $this->movingAveragePrice;
    }

    public function setMovingAveragePrice(?float $movingAveragePrice): ItemVariation
    {
        $this->movingAveragePrice = $movingAveragePrice;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return ItemVariation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     *
     * @return ItemVariation
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getRelatedUpdatedAt()
    {
        return $this->relatedUpdatedAt;
    }

    /**
     * @param DateTime $relatedUpdatedAt
     *
     * @return ItemVariation
     */
    public function setRelatedUpdatedAt($relatedUpdatedAt)
    {
        $this->relatedUpdatedAt = $relatedUpdatedAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriceCalculationId()
    {
        return $this->priceCalculationId;
    }

    /**
     * @param int $priceCalculationId
     *
     * @return ItemVariation
     */
    public function setPriceCalculationId($priceCalculationId)
    {
        $this->priceCalculationId = $priceCalculationId;

        return $this;
    }

    /**
     * @return string
     */
    public function getPicking()
    {
        return $this->picking;
    }

    /**
     * @param string $picking
     *
     * @return ItemVariation
     */
    public function setPicking($picking)
    {
        $this->picking = $picking;

        return $this;
    }

    /**
     * @return int
     */
    public function getStockLimitation()
    {
        return $this->stockLimitation;
    }

    /**
     * @param int $stockLimitation
     *
     * @return ItemVariation
     */
    public function setStockLimitation($stockLimitation)
    {
        $this->stockLimitation = $stockLimitation;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsVisibleIfNetStockIsPositive()
    {
        return $this->isVisibleIfNetStockIsPositive;
    }

    /**
     * @param bool $isVisibleIfNetStockIsPositive
     *
     * @return ItemVariation
     */
    public function setIsVisibleIfNetStockIsPositive($isVisibleIfNetStockIsPositive)
    {
        $this->isVisibleIfNetStockIsPositive = $isVisibleIfNetStockIsPositive;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsInvisibleIfNetStockIsNotPositive()
    {
        return $this->isInvisibleIfNetStockIsNotPositive;
    }

    /**
     * @param bool $isInvisibleIfNetStockIsNotPositive
     *
     * @return ItemVariation
     */
    public function setIsInvisibleIfNetStockIsNotPositive($isInvisibleIfNetStockIsNotPositive)
    {
        $this->isInvisibleIfNetStockIsNotPositive = $isInvisibleIfNetStockIsNotPositive;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsAvailableIfNetStockIsPositive()
    {
        return $this->isAvailableIfNetStockIsPositive;
    }

    /**
     * @param bool $isAvailableIfNetStockIsPositive
     *
     * @return ItemVariation
     */
    public function setIsAvailableIfNetStockIsPositive($isAvailableIfNetStockIsPositive)
    {
        $this->isAvailableIfNetStockIsPositive = $isAvailableIfNetStockIsPositive;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsUnavailableIfNetStockIsNotPositive()
    {
        return $this->isUnavailableIfNetStockIsNotPositive;
    }

    /**
     * @param bool $isUnavailableIfNetStockIsNotPositive
     *
     * @return ItemVariation
     */
    public function setIsUnavailableIfNetStockIsNotPositive($isUnavailableIfNetStockIsNotPositive)
    {
        $this->isUnavailableIfNetStockIsNotPositive = $isUnavailableIfNetStockIsNotPositive;

        return $this;
    }

    /**
     * @return int
     */
    public function getMainWarehouseId()
    {
        return $this->mainWarehouseId;
    }

    /**
     * @param int $mainWarehouseId
     *
     * @return ItemVariation
     */
    public function setMainWarehouseId($mainWarehouseId)
    {
        $this->mainWarehouseId = $mainWarehouseId;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaximumOrderQuantity()
    {
        return $this->maximumOrderQuantity;
    }

    /**
     * @param int $maximumOrderQuantity
     *
     * @return ItemVariation
     */
    public function setMaximumOrderQuantity($maximumOrderQuantity)
    {
        $this->maximumOrderQuantity = $maximumOrderQuantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumOrderQuantity()
    {
        return $this->minimumOrderQuantity;
    }

    /**
     * @param int $minimumOrderQuantity
     *
     * @return ItemVariation
     */
    public function setMinimumOrderQuantity($minimumOrderQuantity)
    {
        $this->minimumOrderQuantity = $minimumOrderQuantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getIntervalOrderQuantity()
    {
        return $this->intervalOrderQuantity;
    }

    /**
     * @param int $intervalOrderQuantity
     *
     * @return ItemVariation
     */
    public function setIntervalOrderQuantity($intervalOrderQuantity)
    {
        $this->intervalOrderQuantity = $intervalOrderQuantity;

        return $this;
    }

    /**
     * @return string
     */
    public function getAvailableUntil()
    {
        return $this->availableUntil;
    }

    /**
     * @param string $availableUntil
     *
     * @return ItemVariation
     */
    public function setAvailableUntil($availableUntil)
    {
        $this->availableUntil = $availableUntil;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getReleasedAt()
    {
        return $this->releasedAt;
    }

    /**
     * @param DateTime $releasedAt
     *
     * @return ItemVariation
     */
    public function setReleasedAt($releasedAt)
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ItemVariation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getWeightG()
    {
        return $this->weightG;
    }

    /**
     * @param int $weightG
     *
     * @return ItemVariation
     */
    public function setWeightG($weightG)
    {
        $this->weightG = $weightG;

        return $this;
    }

    /**
     * @return int
     */
    public function getWeightNetG()
    {
        return $this->weightNetG;
    }

    /**
     * @param int $weightNetG
     *
     * @return ItemVariation
     */
    public function setWeightNetG($weightNetG)
    {
        $this->weightNetG = $weightNetG;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidthMM()
    {
        return $this->widthMM;
    }

    /**
     * @param int $widthMM
     *
     * @return ItemVariation
     */
    public function setWidthMM($widthMM)
    {
        $this->widthMM = $widthMM;

        return $this;
    }

    /**
     * @return int
     */
    public function getLengthMM()
    {
        return $this->lengthMM;
    }

    /**
     * @param int $lengthMM
     *
     * @return ItemVariation
     */
    public function setLengthMM($lengthMM)
    {
        $this->lengthMM = $lengthMM;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeightMM()
    {
        return $this->heightMM;
    }

    /**
     * @param int $heightMM
     *
     * @return ItemVariation
     */
    public function setHeightMM($heightMM)
    {
        $this->heightMM = $heightMM;

        return $this;
    }

    /**
     * @return float
     */
    public function getExtraShippingCharge1()
    {
        return $this->extraShippingCharge1;
    }

    /**
     * @param float $extraShippingCharge1
     *
     * @return ItemVariation
     */
    public function setExtraShippingCharge1($extraShippingCharge1)
    {
        $this->extraShippingCharge1 = $extraShippingCharge1;

        return $this;
    }

    /**
     * @return float
     */
    public function getExtraShippingCharge2()
    {
        return $this->extraShippingCharge2;
    }

    /**
     * @param float $extraShippingCharge2
     *
     * @return ItemVariation
     */
    public function setExtraShippingCharge2($extraShippingCharge2)
    {
        $this->extraShippingCharge2 = $extraShippingCharge2;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnitsContained()
    {
        return $this->unitsContained;
    }

    /**
     * @param int $unitsContained
     *
     * @return ItemVariation
     */
    public function setUnitsContained($unitsContained)
    {
        $this->unitsContained = $unitsContained;

        return $this;
    }

    /**
     * @return int
     */
    public function getPalletTypeId()
    {
        return $this->palletTypeId;
    }

    /**
     * @param int $palletTypeId
     *
     * @return ItemVariation
     */
    public function setPalletTypeId($palletTypeId)
    {
        $this->palletTypeId = $palletTypeId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPackingUnits()
    {
        return $this->packingUnits;
    }

    /**
     * @param int $packingUnits
     *
     * @return ItemVariation
     */
    public function setPackingUnits($packingUnits)
    {
        $this->packingUnits = $packingUnits;

        return $this;
    }

    /**
     * @return int
     */
    public function getPackingUnitTypeId()
    {
        return $this->packingUnitTypeId;
    }

    /**
     * @param int $packingUnitTypeId
     *
     * @return ItemVariation
     */
    public function setPackingUnitTypeId($packingUnitTypeId)
    {
        $this->packingUnitTypeId = $packingUnitTypeId;

        return $this;
    }

    /**
     * @return float
     */
    public function getTransportationCosts()
    {
        return $this->transportationCosts;
    }

    /**
     * @param float $transportationCosts
     *
     * @return ItemVariation
     */
    public function setTransportationCosts($transportationCosts)
    {
        $this->transportationCosts = $transportationCosts;

        return $this;
    }

    /**
     * @return float
     */
    public function getStorageCosts()
    {
        return $this->storageCosts;
    }

    /**
     * @param float $storageCosts
     *
     * @return ItemVariation
     */
    public function setStorageCosts($storageCosts)
    {
        $this->storageCosts = $storageCosts;

        return $this;
    }

    /**
     * @return float
     */
    public function getCustoms()
    {
        return $this->customs;
    }

    /**
     * @param float $customs
     *
     * @return ItemVariation
     */
    public function setCustoms($customs)
    {
        $this->customs = $customs;

        return $this;
    }

    /**
     * @return float
     */
    public function getOperatingCosts()
    {
        return $this->operatingCosts;
    }

    /**
     * @param float $operatingCosts
     *
     * @return ItemVariation
     */
    public function setOperatingCosts($operatingCosts)
    {
        $this->operatingCosts = $operatingCosts;

        return $this;
    }

    /**
     * @return int
     */
    public function getVatId()
    {
        return $this->vatId;
    }

    /**
     * @param int $vatId
     *
     * @return ItemVariation
     */
    public function setVatId($vatId)
    {
        $this->vatId = $vatId;

        return $this;
    }

    /**
     * @return string
     */
    public function getBundleType()
    {
        return $this->bundleType;
    }

    /**
     * @param string $bundleType
     *
     * @return ItemVariation
     */
    public function setBundleType($bundleType)
    {
        $this->bundleType = $bundleType;

        return $this;
    }

    /**
     * @return int
     */
    public function getAutomaticClientVisibility()
    {
        return $this->automaticClientVisibility;
    }

    /**
     * @param int $automaticClientVisibility
     *
     * @return ItemVariation
     */
    public function setAutomaticClientVisibility($automaticClientVisibility)
    {
        $this->automaticClientVisibility = $automaticClientVisibility;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsHiddenInCategoryList()
    {
        return $this->isHiddenInCategoryList;
    }

    /**
     * @param bool $isHiddenInCategoryList
     *
     * @return ItemVariation
     */
    public function setIsHiddenInCategoryList($isHiddenInCategoryList)
    {
        $this->isHiddenInCategoryList = $isHiddenInCategoryList;

        return $this;
    }

    /**
     * @return float
     */
    public function getDefaultShippingCosts()
    {
        return $this->defaultShippingCosts;
    }

    /**
     * @param float $defaultShippingCosts
     *
     * @return ItemVariation
     */
    public function setDefaultShippingCosts($defaultShippingCosts)
    {
        $this->defaultShippingCosts = $defaultShippingCosts;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMayShowUnitPrice()
    {
        return $this->mayShowUnitPrice;
    }

    /**
     * @param bool $mayShowUnitPrice
     *
     * @return ItemVariation
     */
    public function setMayShowUnitPrice($mayShowUnitPrice)
    {
        $this->mayShowUnitPrice = $mayShowUnitPrice;

        return $this;
    }

    /**
     * @return array|ItemImage[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param array|ItemImage[] $images
     *
     * @return ItemVariation
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    public function getItemImages(): array
    {
        return $this->itemImages;
    }

    public function setItemImages(array $itemImages): ItemVariation
    {
        $this->itemImages = $itemImages;

        return $this;
    }

    /**
     * @return array|ItemVariationBarcode[]
     */
    public function getVariationBarcodes()
    {
        return $this->variationBarcodes;
    }

    /**
     * @param array|ItemVariationBarcode[] $variationBarcodes
     *
     * @return ItemVariation
     */
    public function setVariationBarcodes($variationBarcodes)
    {
        $this->variationBarcodes = $variationBarcodes;

        return $this;
    }

    /**
     * @return array|ItemVariationSalesPrice[]
     */
    public function getVariationSalesPrices()
    {
        return $this->variationSalesPrices;
    }

    /**
     * @param array|ItemVariationSalesPrice[] $variationSalesPrices
     *
     * @return ItemVariation
     */
    public function setVariationSalesPrices($variationSalesPrices)
    {
        $this->variationSalesPrices = $variationSalesPrices;

        return $this;
    }

    /**
     * @return array|ItemVariationMarket[]
     */
    public function getVariationMarkets()
    {
        return $this->variationMarkets;
    }

    /**
     * @param array|ItemVariationMarket[] $variationMarkets
     *
     * @return ItemVariation
     */
    public function setVariationMarkets($variationMarkets)
    {
        $this->variationMarkets = $variationMarkets;

        return $this;
    }

    /**
     * @return array|ItemVariationMarketNumber[]
     */
    public function getMarketItemNumbers()
    {
        return $this->marketItemNumbers;
    }

    /**
     * @param array|ItemVariationMarketNumber[] $marketItemNumbers
     *
     * @return ItemVariation
     */
    public function setMarketItemNumbers($marketItemNumbers)
    {
        $this->marketItemNumbers = $marketItemNumbers;

        return $this;
    }

    /**
     * @return array|ItemVariationBundleComponent[]
     */
    public function getVariationBundleComponents()
    {
        return $this->variationBundleComponents;
    }

    /**
     * @param array|ItemVariationBundleComponent[] $variationBundleComponents
     *
     * @return ItemVariation
     */
    public function setVariationBundleComponents($variationBundleComponents)
    {
        $this->variationBundleComponents = $variationBundleComponents;

        return $this;
    }

    /**
     * @return array|ItemVariationCharacteristic[]
     */
    public function getVariationCharacteristics()
    {
        return $this->variationCharacteristics;
    }

    /**
     * @param array|ItemVariationCharacteristic[] $variationCharacteristics
     *
     * @return ItemVariation
     */
    public function setVariationCharacteristics($variationCharacteristics)
    {
        $this->variationCharacteristics = $variationCharacteristics;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsVisibleInListIfNetStockIsPositive()
    {
        return $this->isVisibleInListIfNetStockIsPositive;
    }

    /**
     * @param bool $isVisibleInListIfNetStockIsPositive
     *
     * @return ItemVariation
     */
    public function setIsVisibleInListIfNetStockIsPositive($isVisibleInListIfNetStockIsPositive)
    {
        $this->isVisibleInListIfNetStockIsPositive = $isVisibleInListIfNetStockIsPositive;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIsInvisibleInListIfNetStockIsNotPositive()
    {
        return $this->isInvisibleInListIfNetStockIsNotPositive;
    }

    /**
     * @param bool $isInvisibleInListIfNetStockIsNotPositive
     *
     * @return ItemVariation
     */
    public function setIsInvisibleInListIfNetStockIsNotPositive($isInvisibleInListIfNetStockIsNotPositive)
    {
        $this->isInvisibleInListIfNetStockIsNotPositive = $isInvisibleInListIfNetStockIsNotPositive;

        return $this;
    }

    public function getVariationSkus(): array
    {
        return $this->variationSkus;
    }

    public function setVariationSkus(array $variationSkus): ItemVariation
    {
        $this->variationSkus = $variationSkus;

        return $this;
    }

    /**
     * @return array|ItemVariationSupplier[]
     */
    public function getVariationSuppliers(): ?array
    {
        return $this->variationSuppliers;
    }

    /**
     * @param array|ItemVariationSupplier[] $variationSuppliers
     *
     * @return ItemVariation
     */
    public function setVariationSuppliers(?array $variationSuppliers = null)
    {
        $this->variationSuppliers = $variationSuppliers;

        return $this;
    }

    /**
     * @return ItemVariationCategory[]
     */
    public function getVariationCategories(): ?array
    {
        return $this->variationCategories;
    }

    /**
     * @param ItemVariationCategory[]|null $variationCategories
     *
     * @return ItemVariation
     */
    public function setVariationCategories(?array $variationCategories = null)
    {
        $this->variationCategories = $variationCategories;

        return $this;
    }

    /**
     * @return ItemVariationTag[]|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @param ItemVariationTag[]|null $tags
     */
    public function setTags(?array $tags): ItemVariation
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return ItemVariationClient[]|null
     */
    public function getVariationClients(): ?array
    {
        return $this->variationClients;
    }

    /**
     * @param ItemVariationClient[]|null $variationClients
     */
    public function setVariationClients(?array $variationClients): ItemVariation
    {
        $this->variationClients = $variationClients;

        return $this;
    }

    /**
     * @return ItemVariationDefaultCategory[]|null
     */
    public function getVariationDefaultCategory(): ?array
    {
        return $this->variationDefaultCategory;
    }

    /**
     * @param ItemVariationDefaultCategory[]|null $variationDefaultCategory
     */
    public function setVariationDefaultCategory(?array $variationDefaultCategory): ItemVariation
    {
        $this->variationDefaultCategory = $variationDefaultCategory;

        return $this;
    }

    /**
     * @return ItemVariationStock[]|null
     */
    public function getStock(): ?array
    {
        return $this->stock;
    }

    /**
     * @param ItemVariationStock[]|null $stock
     */
    public function setStock(?array $stock): ItemVariation
    {
        $this->stock = $stock;

        return $this;
    }

    public function getUnit(): ?ItemVariationUnit
    {
        return $this->unit;
    }

    public function setUnit(?ItemVariationUnit $unit): ItemVariation
    {
        $this->unit = $unit;

        return $this;
    }

    public function getCustomsTariffNumber(): ?string
    {
        return $this->customsTariffNumber;
    }

    public function setCustomsTariffNumber(?string $customsTariffNumber): ItemVariation
    {
        $this->customsTariffNumber = $customsTariffNumber;

        return $this;
    }

    /**
     * @return ItemVariationWarehouse[]|null
     */
    public function getVariationWarehouses(): ?array
    {
        return $this->variationWarehouses;
    }

    /**
     * @param ItemVariationWarehouse[]|null $variationWarehouses
     */
    public function setVariationWarehouses(?array $variationWarehouses): ItemVariation
    {
        $this->variationWarehouses = $variationWarehouses;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): ItemVariation
    {
        $this->item = $item;

        return $this;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function setProperties(array $properties): ItemVariation
    {
        $this->properties = $properties;

        return $this;
    }
}
