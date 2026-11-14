<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 31.08.2017
 * Time: 11:37
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;

/**
 * Class Manufacturer
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class Manufacturer
{
    /** @var int|null */
    private ?int $id = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var string|null */
    private ?string $externalName = null;

    /** @var string|null */
    private ?string $logo = null;

    /** @var string|null */
    private ?string $street = null;

    /** @var string|null */
    private ?string $houseNo = null;

    /** @var string|null */
    private ?string $postcode = null;

    /** @var string|null */
    private ?string $town = null;

    /** @var string|null */
    private ?string $phoneNumber = null;

    /** @var string|null */
    private ?string $faxNumber = null;

    /** @var string|null */
    private ?string $email = null;

    /** @var int|null */
    private ?int $countryId = null;

    /** @var int|null */
    private ?int $pixmaniaBrandId = null;

    /** @var int|null */
    private ?int $neckermannAtEpBrandId = null;

    /** @var int|null */
    private ?int $laRedouteBrandId = null;

    /** @var int|null */
    private ?int $position = null;

    /** @var string|null */
    private ?string $comment = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;


    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Item\ManufacturerCommission>|null */
    private ?array $commissions = null;

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
     * @return Manufacturer
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return Manufacturer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getExternalName()
    {
        return $this->externalName;
    }

    /**
     * @param string $externalName
     *
     * @return Manufacturer
     */
    public function setExternalName($externalName)
    {
        $this->externalName = $externalName;

        return $this;
    }

    /**
     * @return string|mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     *
     * @return Manufacturer
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     *
     * @return Manufacturer
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getHouseNo()
    {
        return $this->houseNo;
    }

    /**
     * @param string $houseNo
     *
     * @return Manufacturer
     */
    public function setHouseNo($houseNo)
    {
        $this->houseNo = $houseNo;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     *
     * @return Manufacturer
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $town
     *
     * @return Manufacturer
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return Manufacturer
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->faxNumber;
    }

    /**
     * @param string $faxNumber
     *
     * @return Manufacturer
     */
    public function setFaxNumber($faxNumber)
    {
        $this->faxNumber = $faxNumber;

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
     * @return Manufacturer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     *
     * @return Manufacturer
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPixmaniaBrandId()
    {
        return $this->pixmaniaBrandId;
    }

    /**
     * @param int $pixmaniaBrandId
     *
     * @return Manufacturer
     */
    public function setPixmaniaBrandId($pixmaniaBrandId)
    {
        $this->pixmaniaBrandId = $pixmaniaBrandId;

        return $this;
    }

    /**
     * @return int
     */
    public function getNeckermannAtEpBrandId()
    {
        return $this->neckermannAtEpBrandId;
    }

    /**
     * @param int $neckermannAtEpBrandId
     *
     * @return Manufacturer
     */
    public function setNeckermannAtEpBrandId($neckermannAtEpBrandId)
    {
        $this->neckermannAtEpBrandId = $neckermannAtEpBrandId;

        return $this;
    }

    /**
     * @return int
     */
    public function getLaRedouteBrandId()
    {
        return $this->laRedouteBrandId;
    }

    /**
     * @param int $laRedouteBrandId
     *
     * @return Manufacturer
     */
    public function setLaRedouteBrandId($laRedouteBrandId)
    {
        $this->laRedouteBrandId = $laRedouteBrandId;

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
     * @return Manufacturer
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return Manufacturer
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

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
     * @return Manufacturer
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return ManufacturerCommission[]
     */
    public function getCommissions()
    {
        return $this->commissions;
    }

    /**
     * @param ManufacturerCommission[] $commissions
     *
     * @return Manufacturer
     */
    public function setCommissions($commissions)
    {
        $this->commissions = $commissions;

        return $this;
    }

}