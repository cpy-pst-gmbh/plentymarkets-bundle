<?php

namespace PM\PlentyMarketsBundle\Component\Model\Item;


class UnitName
{
    /** @var string|null */
    private ?string $lang = null;

    /** @var string|null */
    private ?string $name = null;

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(?string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
