<?php

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use DateTime;
use PM\PlentyMarketsBundle\Component\Model\Account\Address;
use PM\PlentyMarketsBundle\Component\Model\Mixed\Tag;

class Order
{
    public const TYPE_SALE = 1;
    public const TYPE_DELIVERY = 2;
    public const TYPE_RETURN = 3;
    public const TYPE_CREDIT = 4;
    public const TYPE_WARRANTY = 5;
    public const TYPE_REPAIR = 6;
    public const TYPE_OFFER = 7;
    public const TYPE_ADVANCED = 8;
    public const TYPE_SALE_MULTI = 9;
    public const TYPE_CREDIT_MULTI = 10;
    public const TYPE_DELIVERY_MULTI = 11;
    public const TYPE_REORDER = 12;
    public const TYPE_DELIVERY_PARTIAL = 13;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderItem>|null */
    private ?array $orderItems = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderProperty>|null */
    private ?array $properties = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Account\Address>|null */
    private ?array $addresses = [];

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderAddressRelation>|null */
    private ?array $addressRelations = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderRelation>|null */
    private ?array $relations = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderAmount>|null */
    private ?array $amounts = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderDate>|null */
    private ?array $dates = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderReference>|null */
    private ?array $orderReferences = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderReference>|null */
    private ?array $originOrderReferences = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderShippingPackage>|null */
    private ?array $shippingPackages = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Mixed\Tag>|null */
    private ?array $tags = null;


    /** @var int|null */
    private ?int $typeId = null;

    /** @var int|null */
    private ?int $plentyId = null;

    /** @var int|null */
    private ?int $locationId = null;

    /** @var float|null */
    private ?float $statusId = null;

    /** @var string|null */
    private ?string $statusName = null;

    /** @var int|null */
    private ?int $ownerId = null;

    /** @var \DateTime|null */
    private ?\DateTime $createdAt = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

    /** @var int|null */
    private ?int $id = null;

    /**
     * Herkuenfte haben Nachkommastellen, 4.01 ist Amazon Deutschland, 2.08 eBay Deutschland.
     *
     * @var float|null
     */
    private ?float $referrerId = null;


    /**
     * @return OrderItem[]|array|null
     */
    public function getOrderItems(): ?array
    {
        return $this->orderItems;
    }

    /**
     * @param OrderItem[]|array|null $orderItems
     *
     * @return Order
     */
    public function setOrderItems(?array $orderItems): Order
    {
        $this->orderItems = $orderItems;

        return $this;
    }

    /**
     * @return OrderProperty[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param OrderProperty[] $properties
     *
     * @return Order
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return array|Address[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param array|Address[] $addresses
     *
     * @return Order
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * @return OrderAddressRelation[]
     */
    public function getAddressRelations()
    {
        return $this->addressRelations;
    }

    /**
     * @param OrderAddressRelation[] $addressRelations
     *
     * @return Order
     */
    public function setAddressRelations($addressRelations)
    {
        $this->addressRelations = $addressRelations;

        return $this;
    }

    /**
     * @return OrderAmount[]
     */
    public function getAmounts()
    {
        return $this->amounts;
    }

    /**
     * @param OrderAmount[] $amounts
     *
     * @return Order
     */
    public function setAmounts($amounts)
    {
        $this->amounts = $amounts;

        return $this;
    }

    /**
     * @return OrderDate[]
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @param OrderDate[] $dates
     *
     * @return Order
     */
    public function setDates($dates)
    {
        $this->dates = $dates;

        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): Order
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param int $typeId
     *
     * @return Order
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlentyId()
    {
        return $this->plentyId;
    }

    /**
     * @param int $plentyId
     *
     * @return Order
     */
    public function setPlentyId($plentyId)
    {
        $this->plentyId = $plentyId;

        return $this;
    }

    /**
     * @return int
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @param int $locationId
     *
     * @return Order
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;

        return $this;
    }

    /**
     * @return float
     */
    public function getStatusId(): float
    {
        return $this->statusId;
    }

    /**
     * @param float $statusId
     *
     * @return Order
     */
    public function setStatusId(float $statusId)
    {
        $this->statusId = $statusId;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        return $this->statusName;
    }

    /**
     * @param string $statusName
     *
     * @return Order
     */
    public function setStatusName($statusName)
    {
        $this->statusName = $statusName;

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
     * @return Order
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

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
     * @return Order
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
     * @return Order
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

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
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getReferrerId(): ?float
    {
        return $this->referrerId;
    }

    /**
     * @return Order
     */
    public function setReferrerId(?float $referrerId): Order
    {
        $this->referrerId = $referrerId;

        return $this;
    }

    /**
     * @return OrderRelation[]
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * @param OrderRelation[] $relations
     *
     * @return Order
     */
    public function setRelations($relations)
    {
        $this->relations = $relations;

        return $this;
    }

    /**
     * @return OrderReference[]
     */
    public function getOrderReferences()
    {
        return $this->orderReferences;
    }

    /**
     * @param OrderReference[] $orderReferences
     *
     * @return Order
     */
    public function setOrderReferences($orderReferences)
    {
        $this->orderReferences = $orderReferences;

        return $this;
    }

    /**
     * @return OrderReference[]
     */
    public function getOriginOrderReferences()
    {
        return $this->originOrderReferences;
    }

    /**
     * @param OrderReference[] $originOrderReferences
     *
     * @return Order
     */
    public function setOriginOrderReferences($originOrderReferences)
    {
        $this->originOrderReferences = $originOrderReferences;

        return $this;
    }

    /**
     * @return null|OrderShippingPackage[]
     */
    public function getShippingPackages(): ?array
    {
        return $this->shippingPackages;
    }

    /**
     * @param null|OrderShippingPackage[] $shippingPackages
     *
     * @return Order
     */
    public function setShippingPackages(?array $shippingPackages): Order
    {
        $this->shippingPackages = $shippingPackages;

        return $this;
    }


    /**
     * Get Address By Id
     *
     *
     */
    public function getAddressById(int $id): ?Address
    {
        foreach ($this->addresses as $address) {
            if ($id === $address->getId()) {
                return $address;
            }
        }

        return null;
    }

    public function getAddressByRelationType(int $relationType): ?Address
    {
        $relation = $this->getAddressRelationByType($relationType);
        if (null === $relation) {
            return null;
        }

        return $this->getAddressById($relation->getAddressId());
    }

    /**
     * @return OrderAddressRelation|null
     */
    public function getAddressRelationByType(int $type): ?OrderAddressRelation
    {
        foreach ($this->addressRelations as $relation) {
            if ($relation->getTypeId() === $type) {
                return $relation;
            }
        }

        return null;
    }

    /**
     * Get Amount Euro
     *
     * @param $currency
     *
     * @return null|OrderAmount
     */
    public function getAmountByCurrency($currency)
    {
        foreach ($this->getAmounts() as $amount) {
            if ($currency === $amount->getCurrency()) {
                return $amount;
            }
        }

        return null;
    }

    /**
     * Get Property By Type Id
     *
     * @param int $typeId
     *
     * @return null|OrderProperty
     */
    public function getPropertyByTypeId($typeId)
    {
        if (false === is_array($this->properties)) {
            return null;
        }

        foreach ($this->getProperties() as $property) {
            if ($typeId === $property->getTypeId()) {
                return $property;
            }
        }

        return null;
    }

    public function getTagById(int $id): ?Tag
    {
        foreach ($this->getTags() as $tag) {
            if ($id === $tag->getId()) {
                return $tag;
            }
        }

        return null;
    }
}