<?php

namespace PM\PlentyMarketsBundle\Component\Model\Order;


class OrderItemWarehouseLocation
{

    /** @var int */
    private readonly int $orderItemId;

    /** @var int */
    private readonly int $quantity;

    /** @var int */
    private readonly int $warehouseLocationId;

    /** @var int */
    private readonly int $batchBestBeforeDateId;

    /** @var int */
    private readonly int $originalQuantity;

    /** @var string */
    private readonly string $batch;

    /** @var string */
    private readonly string $bestBeforeDate;

    public function getOrderItemId(): int
    {
        return $this->orderItemId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getWarehouseLocationId(): int
    {
        return $this->warehouseLocationId;
    }

    public function getBatchBestBeforeDateId(): int
    {
        return $this->batchBestBeforeDateId;
    }

    public function getOriginalQuantity(): int
    {
        return $this->originalQuantity;
    }

    public function getBatch(): string
    {
        return $this->batch;
    }

    public function getBestBeforeDate(): string
    {
        return $this->bestBeforeDate;
    }

}