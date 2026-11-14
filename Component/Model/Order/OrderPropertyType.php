<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 23.01.2018
 * Time: 14:00
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;


/**
 * Class OrderPropertyType
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderPropertyType
{
    /** @var int|null */
    private ?int $id = null;

    /** @var bool|null */
    private ?bool $isErasable = null;

    /** @var int|null */
    private ?int $position = null;

    /** @var string|null */
    private ?string $cast = null;

    /** @var list<\PM\PlentyMarketsBundle\Component\Model\Order\OrderPropertyTypeName>|null */
    private ?array $names = null;

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
     * @return OrderPropertyType
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsErasable()
    {
        return $this->isErasable;
    }

    /**
     * @param boolean $isErasable
     *
     * @return OrderPropertyType
     */
    public function setIsErasable($isErasable)
    {
        $this->isErasable = $isErasable;

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
     * @return OrderPropertyType
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getCast()
    {
        return $this->cast;
    }

    /**
     * @param string $cast
     *
     * @return OrderPropertyType
     */
    public function setCast($cast)
    {
        $this->cast = $cast;

        return $this;
    }

    /**
     * @return OrderPropertyTypeName[]
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param OrderPropertyTypeName[] $names
     *
     * @return OrderPropertyType
     */
    public function setNames($names)
    {
        $this->names = $names;

        return $this;
    }

    /**
     * Get Name By Language
     *
     * @param string $language
     *
     * @return null|OrderPropertyTypeName
     */
    public function getNameByLanguage($language)
    {
        foreach ($this->getNames() as $name) {
            if ($language === $name->getLang()) {
                return $name;
            }
        }

        return null;
    }
}