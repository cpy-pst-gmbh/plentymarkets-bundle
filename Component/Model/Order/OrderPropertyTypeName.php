<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 23.01.2018
 * Time: 14:05
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;


/**
 * Class OrderPropertyTypeName
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderPropertyTypeName
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $typeId = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var string|null */
    private ?string $lang = null;

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
     * @return OrderPropertyTypeName
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return OrderPropertyTypeName
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

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
     * @return OrderPropertyTypeName
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return OrderPropertyTypeName
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

}