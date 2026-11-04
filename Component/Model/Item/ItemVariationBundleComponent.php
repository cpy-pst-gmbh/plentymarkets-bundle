<?php


namespace PM\PlentyMarketsBundle\Component\Model\Item;

use JMS\Serializer\Annotation as JMS;

/**
 * Class ItemVariationBundleComponent
 *
 * Bestandteil einer Bundle-Variante, with=variationBundleComponents
 *
 * @package PM\PlentyMarketsBundle\Component\Model\Item
 */
#[JMS\ExclusionPolicy('ALL')]
class ItemVariationBundleComponent
{
    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $id;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $variationId;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $componentVariationId;

    /**
     * @var int
     */
    #[JMS\Type('integer')]
    #[JMS\Expose]
    #[JMS\Since('1.0')]
    private $componentQuantity;

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
