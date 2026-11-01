<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 05.09.2017
 * Time: 14:43
 */

namespace PM\PlentyMarketsBundle\Component\Model\Account;

use DateTime;
use JMS\Serializer\Annotation as JMS;
use PM\PlentyMarketsBundle\Component\Config\CountryIdType;

/**
 * Class Contact
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Account
 */
#[JMS\ExclusionPolicy('ALL')]
class Contact
{
    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $id;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $number;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $externalId;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $typeId;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $firstName;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $lastName;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $gender;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $title;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $formOfAddress;

    /**
     * @var DateTime
     */
    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $newsletterAllowanceAt;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $classId;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $blocked;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $rating;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $bookAccount;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $lang;

    /**
     * @var float
     */
    #[JMS\Type('float')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $referrerId;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $userId;

    /**
     * @var DateTime
     */
    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $birthdayAt;

    /**
     * @var DateTime
     */
    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $lastLoginAt;

    /**
     * @var DateTime
     */
    #[JMS\Type('DateTime')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $lastOrderAt;

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
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $plentyId;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $email;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $ebayName;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $privatePhone;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $privateFax;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $privateMobile;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $paypalEmail;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $paypalPayerId;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $klarnaPersonalId;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $dhlPostIdent;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $singleAccess;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $contactPerson;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $marketplacePartner;

    /**
     * @var string
     */
    #[JMS\Type('string')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $fullName;


    /**
     * @var ContactOption
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Account\ContactOption>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $options;

    /**
     * Payment settings, with=allowedMethodsOfPayment. Null when not requested.
     *
     * @var ContactAllowedMethodOfPayment[]|null
     */
    #[JMS\Type('array<PM\PlentyMarketsBundle\Component\Model\Account\ContactAllowedMethodOfPayment>')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?array $allowedMethodsOfPayment = null;

    #[JMS\Type('boolean')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private ?bool $isAnonymized = null;

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
     * @return Contact
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return Contact
     */
    public function setNumber($number)
    {
        $this->number = $number;

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
     * @return Contact
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

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
     * @return Contact
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return Contact
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return Contact
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Contact
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormOfAddress()
    {
        return $this->formOfAddress;
    }

    /**
     * @param string $formOfAddress
     *
     * @return Contact
     */
    public function setFormOfAddress($formOfAddress)
    {
        $this->formOfAddress = $formOfAddress;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getNewsletterAllowanceAt()
    {
        return $this->newsletterAllowanceAt;
    }

    /**
     * @param DateTime $newsletterAllowanceAt
     *
     * @return Contact
     */
    public function setNewsletterAllowanceAt($newsletterAllowanceAt)
    {
        $this->newsletterAllowanceAt = $newsletterAllowanceAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * @param int $classId
     *
     * @return Contact
     */
    public function setClassId($classId)
    {
        $this->classId = $classId;

        return $this;
    }

    /**
     * @return int
     */
    public function getBlocked()
    {
        return $this->blocked;
    }

    /**
     * @param int $blocked
     *
     * @return Contact
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;

        return $this;
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     *
     * @return Contact
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return string
     */
    public function getBookAccount()
    {
        return $this->bookAccount;
    }

    /**
     * @param string $bookAccount
     *
     * @return Contact
     */
    public function setBookAccount($bookAccount)
    {
        $this->bookAccount = $bookAccount;

        return $this;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     *
     * @return Contact
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return float
     */
    public function getReferrerId()
    {
        return $this->referrerId;
    }

    /**
     * @param float $referrerId
     *
     * @return Contact
     */
    public function setReferrerId($referrerId)
    {
        $this->referrerId = $referrerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return Contact
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getBirthdayAt()
    {
        return $this->birthdayAt;
    }

    /**
     * @param DateTime $birthdayAt
     *
     * @return Contact
     */
    public function setBirthdayAt($birthdayAt)
    {
        $this->birthdayAt = $birthdayAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastLoginAt()
    {
        return $this->lastLoginAt;
    }

    /**
     * @param DateTime $lastLoginAt
     *
     * @return Contact
     */
    public function setLastLoginAt($lastLoginAt)
    {
        $this->lastLoginAt = $lastLoginAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastOrderAt()
    {
        return $this->lastOrderAt;
    }

    /**
     * @param DateTime $lastOrderAt
     *
     * @return Contact
     */
    public function setLastOrderAt($lastOrderAt)
    {
        $this->lastOrderAt = $lastOrderAt;

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
     * @return Contact
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
     * @return Contact
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

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
     * @return Contact
     */
    public function setPlentyId($plentyId)
    {
        $this->plentyId = $plentyId;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEbayName()
    {
        return $this->ebayName;
    }

    /**
     * @param string $ebayName
     *
     * @return Contact
     */
    public function setEbayName($ebayName)
    {
        $this->ebayName = $ebayName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrivatePhone()
    {
        return $this->privatePhone;
    }

    /**
     * @param string $privatePhone
     *
     * @return Contact
     */
    public function setPrivatePhone($privatePhone)
    {
        $this->privatePhone = $privatePhone;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrivateFax()
    {
        return $this->privateFax;
    }

    /**
     * @param string $privateFax
     *
     * @return Contact
     */
    public function setPrivateFax($privateFax)
    {
        $this->privateFax = $privateFax;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrivateMobile()
    {
        return $this->privateMobile;
    }

    /**
     * @param string $privateMobile
     *
     * @return Contact
     */
    public function setPrivateMobile($privateMobile)
    {
        $this->privateMobile = $privateMobile;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaypalEmail()
    {
        return $this->paypalEmail;
    }

    /**
     * @param string $paypalEmail
     *
     * @return Contact
     */
    public function setPaypalEmail($paypalEmail)
    {
        $this->paypalEmail = $paypalEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaypalPayerId()
    {
        return $this->paypalPayerId;
    }

    /**
     * @param string $paypalPayerId
     *
     * @return Contact
     */
    public function setPaypalPayerId($paypalPayerId)
    {
        $this->paypalPayerId = $paypalPayerId;

        return $this;
    }

    /**
     * @return string
     */
    public function getKlarnaPersonalId()
    {
        return $this->klarnaPersonalId;
    }

    /**
     * @param string $klarnaPersonalId
     *
     * @return Contact
     */
    public function setKlarnaPersonalId($klarnaPersonalId)
    {
        $this->klarnaPersonalId = $klarnaPersonalId;

        return $this;
    }

    /**
     * @return string
     */
    public function getDhlPostIdent()
    {
        return $this->dhlPostIdent;
    }

    /**
     * @param string $dhlPostIdent
     *
     * @return Contact
     */
    public function setDhlPostIdent($dhlPostIdent)
    {
        $this->dhlPostIdent = $dhlPostIdent;

        return $this;
    }

    /**
     * @return string
     */
    public function getSingleAccess()
    {
        return $this->singleAccess;
    }

    /**
     * @param string $singleAccess
     *
     * @return Contact
     */
    public function setSingleAccess($singleAccess)
    {
        $this->singleAccess = $singleAccess;

        return $this;
    }

    /**
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * @param string $contactPerson
     *
     * @return Contact
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    /**
     * @return string
     */
    public function getMarketplacePartner()
    {
        return $this->marketplacePartner;
    }

    /**
     * @param string $marketplacePartner
     *
     * @return Contact
     */
    public function setMarketplacePartner($marketplacePartner)
    {
        $this->marketplacePartner = $marketplacePartner;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     *
     * @return Contact
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return ContactOption
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param ContactOption $options
     *
     * @return Contact
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return ContactAllowedMethodOfPayment[]|null
     */
    public function getAllowedMethodsOfPayment(): ?array
    {
        return $this->allowedMethodsOfPayment;
    }

    /**
     * @param ContactAllowedMethodOfPayment[]|null $allowedMethodsOfPayment
     */
    public function setAllowedMethodsOfPayment(?array $allowedMethodsOfPayment): self
    {
        $this->allowedMethodsOfPayment = $allowedMethodsOfPayment;

        return $this;
    }

    public function isAnonymized(): ?bool
    {
        return $this->isAnonymized;
    }

    public function setIsAnonymized(?bool $isAnonymized): self
    {
        $this->isAnonymized = $isAnonymized;

        return $this;
    }
}
