<?php

namespace PM\PlentyMarketsBundle\Component\Model\Order;

use DateTime;
use JMS\Serializer\Annotation as JMS;
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

    /**
     * @var OrderItem[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Order\OrderItem>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $orderItems;

    /**
     * @var OrderProperty[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Order\OrderProperty>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $properties;

    /**
     * @var Address[]|array
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Account\Address>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $addresses = [];

    /**
     * @var OrderAddressRelation[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Order\OrderAddressRelation>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $addressRelations;

    /**
     * @var OrderRelation[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Order\OrderRelation>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $relations;

    /**
     * @var OrderAmount[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Order\OrderAmount>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $amounts;

    /**
     * @var OrderDate[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Order\OrderDate>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $dates;

    /**
     * @var OrderReference[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Order\OrderReference>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $orderReferences;

    /**
     * @var OrderReference[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Order\OrderReference>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $originOrderReferences;

    /**
     * @var null|OrderShippingPackage[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Order\OrderShippingPackage>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $shippingPackages;

    /**
     * @var array|Tag[]
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Mixed\Tag>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $tags;


    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $typeId;

    /**
     * @var int
     */
    #[JMS\Type('int')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $plentyId;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $locationId;

    /**
     * @var float
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $statusId;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $statusName;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $ownerId;

    /**
     * @var DateTime
     */
    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $createdAt;

    /**
     * @var DateTime
     */
    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $updatedAt;

    /**
     * @var int
     */
    #[JMS\Type('int')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $id;

    /**
     * @var int
     */
    #[JMS\Type('int')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $referrerId;


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
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * @param float $statusId
     *
     * @return Order
     */
    public function setStatusId($statusId)
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

    public function getReferrerId(): ?int
    {
        return $this->referrerId;
    }

    /**
     * @return Order
     */
    public function setReferrerId(?int $referrerId): Order
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