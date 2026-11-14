<?php

namespace PM\PlentyMarketsBundle\Component\Model\Order;


class ParcelServiceName
{
    /** @var int|null */
    private ?int $id = null;

    /** @var string|null */
    private ?string $lang = null;

    /** @var string|null */
    private ?string $name = null;

    /** @var string|null */
    private ?string $parcelServiceId = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getParcelServiceId()
    {
        return $this->parcelServiceId;
    }

    public function setParcelServiceId($parcelServiceId)
    {
        $this->parcelServiceId = $parcelServiceId;
        return $this;
    }
}