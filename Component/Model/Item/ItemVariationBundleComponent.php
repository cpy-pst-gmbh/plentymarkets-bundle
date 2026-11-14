<?php


namespace PM\PlentyMarketsBundle\Component\Model\Item;


/**
 * Class ItemVariationBundleComponent
 *
 * Bestandteil einer Bundle-Variante, with=variationBundleComponents
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
class ItemVariationBundleComponent
{
    /** @var int|null */
    private ?int $id = null;

    /** @var int|null */
    private ?int $variationId = null;

    /** @var int|null */
    private ?int $componentVariationId = null;

    /** @var int|null */
    private ?int $componentQuantity = null;

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
     * @return ItemVariationBundleComponent
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getVariationId()
    {
        return $this->variationId;
    }

    /**
     * @param int $variationId
     *
     * @return ItemVariationBundleComponent
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getComponentVariationId()
    {
        return $this->componentVariationId;
    }

    /**
     * @param int $componentVariationId
     *
     * @return ItemVariationBundleComponent
     */
    public function setComponentVariationId($componentVariationId)
    {
        $this->componentVariationId = $componentVariationId;

        return $this;
    }

    /**
     * @return int
     */
    public function getComponentQuantity()
    {
        return $this->componentQuantity;
    }

    /**
     * @param int $componentQuantity
     *
     * @return ItemVariationBundleComponent
     */
    public function setComponentQuantity($componentQuantity)
    {
        $this->componentQuantity = $componentQuantity;

        return $this;
    }
}
