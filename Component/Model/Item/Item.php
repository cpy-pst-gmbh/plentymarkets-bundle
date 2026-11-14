<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;

/**
 * Class Item
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class Item
{
    public const FIELD_FREE2 = 'free2';

    public const REASON_INCOMING_ITEMS = 101;

    public const REASON_STOCK_CORRECTION = 301;
    public const REASON_STOCK_CORRECTION_STOCKTAKING = 302;
    public const REASON_STOCK_CORRECTION_PACKING_ERROR = 306;

    public const REASON_STOCK_REDISTRIBUTE = 401;

    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $position = null;

    /** @var string|null */
    private ?string $itemType = null;

    /** @var int|null */
    private ?int $stockType = null;

    /** @var int|null */
    private ?int $storeSpecial = null;

    /** @var int|null */
    private ?int $ownerId = null;

    /** @var int|null */
    private ?int $manufacturerId = null;

    /** @var int|null */
    private ?int $producingCountryId = null;

    /** @var int|null */
    private ?int $mainVariationId = null;

    /** @var string|null */
    private ?string $customsTariffNumber = null;

    /** @var int|null */
    private ?int $revenueAccount = null;

    /** @var int|null */
    private ?int $couponRestriction = null;

    /** @var int|null */
    private ?int $condition = null;


    /** @var int|null */
    private ?int $conditionApi = null;


    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

    /** @var bool|null */
    private ?bool $isSubscribable = null;

    /** @var bool|null */
    private ?bool $isSerialNumber = null;

    /** @var int|null */
    private ?int $amazonFbaPlatform = null;

    /** @var bool|null */
    private ?bool $isShippableByAmazon = null;

    /** @var int|null */
    private ?int $amazonProductType = null;

    /** @var string|null */
    private ?string $amazonFedas = null;

    /** @var int|null */
    private ?int $ebayPresetId = null;

    /** @var int|null */
    private ?int $ebayCategory = null;

    /** @var int|null */
    private ?int $ebayCategory2 = null;

    /** @var int|null */
    private ?int $ebayStoreCategory = null;

    /** @var int|null */
    private ?int $ebayStoreCategory2 = null;

    /** @var int|null */
    private ?int $rakutenCategoryId = null;

    /** @var int|null */
    private ?int $flagOne = null;

    /** @var int|null */
    private ?int $flagTwo = null;

    /** @var int|null */
    private ?int $ageRestriction = null;

    /** @var int|null */
    private ?int $feedback = null;

    /** @var string|null */
    private ?string $free1 = null;

    /** @var string|null */
    private ?string $free2 = null;

    /** @var string|null */
    private ?string $free3 = null;

    /** @var string|null */
    private ?string $free4 = null;

    /** @var string|null */
    private ?string $free5 = null;

    /** @var string|null */
    private ?string $free6 = null;

    /** @var string|null */
    private ?string $free7 = null;

    /** @var string|null */
    private ?string $free8 = null;

    /** @var string|null */
    private ?string $free9 = null;

    /** @var string|null */
    private ?string $free10 = null;

    /** @var string|null */
    private ?string $free11 = null;

    /** @var string|null */
    private ?string $free12 = null;

    /** @var string|null */
    private ?string $free13 = null;

    /** @var string|null */
    private ?string $free14 = null;

    /** @var string|null */
    private ?string $free15 = null;

    /** @var string|null */
    private ?string $free16 = null;

    /** @var string|null */
    private ?string $free17 = null;

    /** @var string|null */
    private ?string $free18 = null;

    /** @var string|null */
    private ?string $free19 = null;

    /** @var string|null */
    private ?string $free20 = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemText>|null */
    private ?array $texts = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemCrossSelling>|null */
    private ?array $itemCrossSelling = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemVariation>|null */
    private ?array $variations = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ItemImage>|null */
    private ?array $itemImages = null;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Item
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return Item
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * @param string $itemType
     *
     * @return Item
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;

        return $this;
    }

    /**
     * @return int
     */
    public function getStockType()
    {
        return $this->stockType;
    }

    /**
     * @param int $stockType
     *
     * @return Item
     */
    public function setStockType($stockType)
    {
        $this->stockType = $stockType;

        return $this;
    }

    /**
     * @return int
     */
    public function getStoreSpecial()
    {
        return $this->storeSpecial;
    }

    /**
     * @param int $storeSpecial
     *
     * @return Item
     */
    public function setStoreSpecial($storeSpecial)
    {
        $this->storeSpecial = $storeSpecial;

        return $this;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param int $ownerId
     *
     * @return Item
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getManufacturerId()
    {
        return $this->manufacturerId;
    }

    /**
     * @param int $manufacturerId
     *
     * @return Item
     */
    public function setManufacturerId($manufacturerId)
    {
        $this->manufacturerId = $manufacturerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getProducingCountryId()
    {
        return $this->producingCountryId;
    }

    /**
     * @param int $producingCountryId
     *
     * @return Item
     */
    public function setProducingCountryId($producingCountryId)
    {
        $this->producingCountryId = $producingCountryId;

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
     * @return Item
     */
    public function setMainVariationId($mainVariationId)
    {
        $this->mainVariationId = $mainVariationId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomsTariffNumber()
    {
        return $this->customsTariffNumber;
    }

    /**
     * @param string $customsTariffNumber
     *
     * @return Item
     */
    public function setCustomsTariffNumber($customsTariffNumber)
    {
        $this->customsTariffNumber = $customsTariffNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getRevenueAccount()
    {
        return $this->revenueAccount;
    }

    /**
     * @param int $revenueAccount
     *
     * @return Item
     */
    public function setRevenueAccount($revenueAccount)
    {
        $this->revenueAccount = $revenueAccount;

        return $this;
    }

    /**
     * @return int
     */
    public function getCouponRestriction()
    {
        return $this->couponRestriction;
    }

    /**
     * @param int $couponRestriction
     *
     * @return Item
     */
    public function setCouponRestriction($couponRestriction)
    {
        $this->couponRestriction = $couponRestriction;

        return $this;
    }

    /**
     * @return int
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param int $condition
     *
     * @return Item
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @return int
     */
    public function getConditionApi()
    {
        return $this->conditionApi;
    }

    /**
     * @param int $conditionApi
     *
     * @return Item
     */
    public function setConditionApi($conditionApi)
    {
        $this->conditionApi = $conditionApi;

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
     * @return Item
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
     * @return Item
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsSubscribable()
    {
        return $this->isSubscribable;
    }

    /**
     * @param boolean $isSubscribable
     *
     * @return Item
     */
    public function setIsSubscribable($isSubscribable)
    {
        $this->isSubscribable = $isSubscribable;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsSerialNumber()
    {
        return $this->isSerialNumber;
    }

    /**
     * @param boolean $isSerialNumber
     *
     * @return Item
     */
    public function setIsSerialNumber($isSerialNumber)
    {
        $this->isSerialNumber = $isSerialNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmazonFbaPlatform()
    {
        return $this->amazonFbaPlatform;
    }

    /**
     * @param int $amazonFbaPlatform
     *
     * @return Item
     */
    public function setAmazonFbaPlatform($amazonFbaPlatform)
    {
        $this->amazonFbaPlatform = $amazonFbaPlatform;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsShippableByAmazon()
    {
        return $this->isShippableByAmazon;
    }

    /**
     * @param boolean $isShippableByAmazon
     *
     * @return Item
     */
    public function setIsShippableByAmazon($isShippableByAmazon)
    {
        $this->isShippableByAmazon = $isShippableByAmazon;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmazonProductType()
    {
        return $this->amazonProductType;
    }

    /**
     * @param int $amazonProductType
     *
     * @return Item
     */
    public function setAmazonProductType($amazonProductType)
    {
        $this->amazonProductType = $amazonProductType;

        return $this;
    }

    /**
     * @return string
     */
    public function getAmazonFedas()
    {
        return $this->amazonFedas;
    }

    /**
     * @param string $amazonFedas
     *
     * @return Item
     */
    public function setAmazonFedas($amazonFedas)
    {
        $this->amazonFedas = $amazonFedas;

        return $this;
    }

    /**
     * @return int
     */
    public function getEbayPresetId()
    {
        return $this->ebayPresetId;
    }

    /**
     * @param int $ebayPresetId
     *
     * @return Item
     */
    public function setEbayPresetId($ebayPresetId)
    {
        $this->ebayPresetId = $ebayPresetId;

        return $this;
    }

    /**
     * @return int
     */
    public function getEbayCategory()
    {
        return $this->ebayCategory;
    }

    /**
     * @param int $ebayCategory
     *
     * @return Item
     */
    public function setEbayCategory($ebayCategory)
    {
        $this->ebayCategory = $ebayCategory;

        return $this;
    }

    /**
     * @return int
     */
    public function getEbayCategory2()
    {
        return $this->ebayCategory2;
    }

    /**
     * @param int $ebayCategory2
     *
     * @return Item
     */
    public function setEbayCategory2($ebayCategory2)
    {
        $this->ebayCategory2 = $ebayCategory2;

        return $this;
    }

    /**
     * @return int
     */
    public function getEbayStoreCategory()
    {
        return $this->ebayStoreCategory;
    }

    /**
     * @param int $ebayStoreCategory
     *
     * @return Item
     */
    public function setEbayStoreCategory($ebayStoreCategory)
    {
        $this->ebayStoreCategory = $ebayStoreCategory;

        return $this;
    }

    /**
     * @return int
     */
    public function getEbayStoreCategory2()
    {
        return $this->ebayStoreCategory2;
    }

    /**
     * @param int $ebayStoreCategory2
     *
     * @return Item
     */
    public function setEbayStoreCategory2($ebayStoreCategory2)
    {
        $this->ebayStoreCategory2 = $ebayStoreCategory2;

        return $this;
    }

    /**
     * @return int
     */
    public function getRakutenCategoryId()
    {
        return $this->rakutenCategoryId;
    }

    /**
     * @param int $rakutenCategoryId
     *
     * @return Item
     */
    public function setRakutenCategoryId($rakutenCategoryId)
    {
        $this->rakutenCategoryId = $rakutenCategoryId;

        return $this;
    }

    /**
     * @return int
     */
    public function getFlagOne()
    {
        return $this->flagOne;
    }

    /**
     * @param int $flagOne
     *
     * @return Item
     */
    public function setFlagOne($flagOne)
    {
        $this->flagOne = $flagOne;

        return $this;
    }

    /**
     * @return int
     */
    public function getFlagTwo()
    {
        return $this->flagTwo;
    }

    /**
     * @param int $flagTwo
     *
     * @return Item
     */
    public function setFlagTwo($flagTwo)
    {
        $this->flagTwo = $flagTwo;

        return $this;
    }

    /**
     * @return int
     */
    public function getAgeRestriction()
    {
        return $this->ageRestriction;
    }

    /**
     * @param int $ageRestriction
     *
     * @return Item
     */
    public function setAgeRestriction($ageRestriction)
    {
        $this->ageRestriction = $ageRestriction;

        return $this;
    }

    /**
     * @return int
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param int $feedback
     *
     * @return Item
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree1()
    {
        return $this->free1;
    }

    /**
     * @param string $free1
     *
     * @return Item
     */
    public function setFree1($free1)
    {
        $this->free1 = $free1;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree2()
    {
        return $this->free2;
    }

    /**
     * @param string $free2
     *
     * @return Item
     */
    public function setFree2($free2)
    {
        $this->free2 = $free2;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree3()
    {
        return $this->free3;
    }

    /**
     * @param string $free3
     *
     * @return Item
     */
    public function setFree3($free3)
    {
        $this->free3 = $free3;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree4()
    {
        return $this->free4;
    }

    /**
     * @param string $free4
     *
     * @return Item
     */
    public function setFree4($free4)
    {
        $this->free4 = $free4;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree5()
    {
        return $this->free5;
    }

    /**
     * @param string $free5
     *
     * @return Item
     */
    public function setFree5($free5)
    {
        $this->free5 = $free5;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree6()
    {
        return $this->free6;
    }

    /**
     * @param string $free6
     *
     * @return Item
     */
    public function setFree6($free6)
    {
        $this->free6 = $free6;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree7()
    {
        return $this->free7;
    }

    /**
     * @param string $free7
     *
     * @return Item
     */
    public function setFree7($free7)
    {
        $this->free7 = $free7;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree8()
    {
        return $this->free8;
    }

    /**
     * @param string $free8
     *
     * @return Item
     */
    public function setFree8($free8)
    {
        $this->free8 = $free8;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree9()
    {
        return $this->free9;
    }

    /**
     * @param string $free9
     *
     * @return Item
     */
    public function setFree9($free9)
    {
        $this->free9 = $free9;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree10()
    {
        return $this->free10;
    }

    /**
     * @param string $free10
     *
     * @return Item
     */
    public function setFree10($free10)
    {
        $this->free10 = $free10;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree11()
    {
        return $this->free11;
    }

    /**
     * @param string $free11
     *
     * @return Item
     */
    public function setFree11($free11)
    {
        $this->free11 = $free11;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree12()
    {
        return $this->free12;
    }

    /**
     * @param string $free12
     *
     * @return Item
     */
    public function setFree12($free12)
    {
        $this->free12 = $free12;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree13()
    {
        return $this->free13;
    }

    /**
     * @param string $free13
     *
     * @return Item
     */
    public function setFree13($free13)
    {
        $this->free13 = $free13;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree14()
    {
        return $this->free14;
    }

    /**
     * @param string $free14
     *
     * @return Item
     */
    public function setFree14($free14)
    {
        $this->free14 = $free14;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree15()
    {
        return $this->free15;
    }

    /**
     * @param string $free15
     *
     * @return Item
     */
    public function setFree15($free15)
    {
        $this->free15 = $free15;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree16()
    {
        return $this->free16;
    }

    /**
     * @param string $free16
     *
     * @return Item
     */
    public function setFree16($free16)
    {
        $this->free16 = $free16;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree17()
    {
        return $this->free17;
    }

    /**
     * @param string $free17
     *
     * @return Item
     */
    public function setFree17($free17)
    {
        $this->free17 = $free17;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree18()
    {
        return $this->free18;
    }

    /**
     * @param string $free18
     *
     * @return Item
     */
    public function setFree18($free18)
    {
        $this->free18 = $free18;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree19()
    {
        return $this->free19;
    }

    /**
     * @param string $free19
     *
     * @return Item
     */
    public function setFree19($free19)
    {
        $this->free19 = $free19;

        return $this;
    }

    /**
     * @return string
     */
    public function getFree20()
    {
        return $this->free20;
    }

    /**
     * @param string $free20
     *
     * @return Item
     */
    public function setFree20($free20)
    {
        $this->free20 = $free20;

        return $this;
    }

    /**
     * @return ItemText[]
     */
    public function getTexts()
    {
        return $this->texts;
    }

    /**
     * @param ItemText[] $texts
     *
     * @return Item
     */
    public function setTexts($texts)
    {
        $this->texts = $texts;

        return $this;
    }

    /**
     * @return ItemCrossSelling[]
     */
    public function getItemCrossSelling()
    {
        return $this->itemCrossSelling;
    }

    /**
     * @param ItemCrossSelling[] $itemCrossSelling
     *
     * @return Item
     */
    public function setItemCrossSelling($itemCrossSelling)
    {
        $this->itemCrossSelling = $itemCrossSelling;

        return $this;
    }

    /**
     * @return ItemVariation[]
     */
    public function getVariations()
    {
        return $this->variations;
    }

    /**
     * @param ItemVariation[] $variations
     *
     * @return Item
     */
    public function setVariations($variations)
    {
        $this->variations = $variations;

        return $this;
    }

    /**
     * @return ItemImage[]
     */
    public function getItemImages(): array
    {
        return $this->itemImages;
    }

    /**
     * @param ItemImage[] $itemImages
     *
     * @return Item
     */
    public function setItemImages(array $itemImages)
    {
        $this->itemImages = $itemImages;

        return $this;
    }

}