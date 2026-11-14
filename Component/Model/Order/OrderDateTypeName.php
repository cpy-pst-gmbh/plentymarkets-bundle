<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 05.09.2017
 * Time: 15:37
 */

namespace PM\PlentyMarketsBundle\Component\Model\Order;


/**
 * Class OrderDateTypeName
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Order
 */
class OrderDateTypeName
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $typeId = null;

    /** @var string|null */
    private ?string $lang = null;

    /** @var string|null */
    private ?string $name = null;

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
     * @return OrderDateTypeName
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
     * @return OrderDateTypeName
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

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
     * @return OrderDateTypeName
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

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
     * @return OrderDateTypeName
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

}