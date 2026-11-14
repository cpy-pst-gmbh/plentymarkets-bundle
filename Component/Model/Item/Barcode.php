<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 30.11.2018
 * Time: 14:47
 */

namespace PM\PlentyMarketsBundle\Component\Model\Item;

use DateTime;

/**
 * Class Barcode
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class Barcode
{
    /** @var int|null */
    private ?int $id = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var string|null */
    private ?string $type = null;

    /** @var \DateTime|null */
    private ?\DateTime $updatedAt = null;

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
     * @return Barcode
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
     * @return Barcode
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Barcode
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns updatedAt, because createdAt contains invalid data
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->updatedAt;
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
     * @return Barcode
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}