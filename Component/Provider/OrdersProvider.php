<?php

namespace PM\PlentyMarketsBundle\Component\Provider;

use DateTimeInterface;
use Exception;
use GuzzleHttp\RequestOptions;
use PM\PlentyMarketsBundle\Component\Model\Order\Order;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderDateType;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderItem;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderPropertyType;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderReferrer;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderShippingPackage;
use PM\PlentyMarketsBundle\Component\Model\Order\OrderShippingPreset;
use PM\PlentyMarketsBundle\Component\Model\Order\StatusHistoryEntry;
use PM\PlentyMarketsBundle\Component\Response\OrderResponse;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Throwable;


class OrdersProvider extends BaseProvider
{

    public function findUpdatedAtFrom(DateTimeInterface $updatedAt, int $page = 1, ?array $with = null): Throwable|OrderResponse
    {
        $options = [
            'query' => [
                'updatedAtFrom' => $updatedAt->format('c'),
                'itemsPerPage' => 250,
                'page' => $page,
                'sortBy' => 'id',
                'sortOrder' => 'asc',
            ],
        ];

        if (null !== $with) {
            $options['query']['with'] = $with;
        }

        $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::ORDERS, $options);
        if ($response instanceof Throwable) {
            return $response;
        }

        $body = $this->getBodyContentsWithFixedDate($response);
        $data = $this->getService()->getSerializer()->deserialize($body, OrderResponse::class, 'json');

        return $data;
    }

    /**
     * One page of orders, filters such as statusFrom or outgoingItemsBookedAtFrom go in $query.
     */
    public function getOrdersPage(int $page = 1, array $query = []): OrderResponse|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::ORDERS,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ],
                    $query
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($this->getBodyContentsWithFixedDate($response), OrderResponse::class, 'json');
    }

    /**
     * ZIP with the documents of an order as binary string, $type being e.g. invoice.
     */
    public function getDocumentsArchive(int $orderId, string $type): string|Throwable
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ORDER_DOCUMENTS_DOWNLOAD, $orderId, $type));

        if ($response instanceof Throwable) {
            return $response;
        }

        return $response->getBody()->getContents();
    }

    public function getByExternalOrderId(string $externalOrderId, ?array $with = null): null|Throwable|Order
    {
        $query = [
            'externalOrderId' => $externalOrderId,
        ];
        if (null !== $with) {
            $query['with'] = $with;
        }


        $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::ORDERS, [
            RequestOptions::QUERY => $query,
        ]);

        if ($response instanceof Throwable) {
            return $response;
        }

        $body = $this->getBodyContentsWithFixedDate($response);

        try {
            /** @var OrderResponse $orderResponse */
            $orderResponse = $this->getService()->getSerializer()->deserialize($body, OrderResponse::class, 'json');
        } catch (Throwable $throwable) {
            return $throwable;
        }

        if (0 === $orderResponse->getTotalsCount()) {
            return new RuntimeException(sprintf('Found no orders for externalOrderId "%s"', $externalOrderId));
        }

        if (1 < $orderResponse->getTotalsCount()) {
            return new RuntimeException(sprintf('Found %d orders for externalOrderId "%s"', $orderResponse->getTotalsCount(), $externalOrderId));
        }

        return $orderResponse->getEntries()[0];
    }

    public function getById(int $orderId, array $query = []): Throwable|Order
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ORDER, $orderId), [RequestOptions::QUERY => $query]);

        if ($response instanceof Throwable) {
            return $response;
        }

        $body = $this->getBodyContentsWithFixedDate($response);

        try {
            return $this->getService()->getSerializer()->deserialize($body, Order::class, 'json');
        } catch (Throwable $throwable) {
            return $throwable;
        }
    }

    public function getByIdWithAddresses(int $orderId): Throwable|Order
    {
        return $this->getById(
            $orderId,
            [
                'with' => ['addresses'],
            ]
        );
    }

    public function getShippingPackages($orderId): array|Throwable
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ORDER_SHIPPING_PACKAGES, $orderId));
        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            sprintf('array<%s>', OrderShippingPackage::class),
            'json'
        );
    }

    public function getStatusHistory($orderId): array|Throwable
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ORDER_STATUS_HISTORY, $orderId));
        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            sprintf('array<%s>', StatusHistoryEntry::class),
            'json'
        );
    }

    /**
     * Get Item By Id
     *
     * @param int $orderId
     * @param int $itemId
     *
     * @return Throwable|null|OrderItem
     * @throws Throwable
     */
    public function getItemById($orderId, $itemId)
    {
        $order = $this->getById($orderId);
        if ($order instanceof Exception) {
            return $order;
        }

        foreach ($order->getOrderItems() as $item) {
            if ($item->getId() === $itemId) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Get Property Type By Id
     *
     * @param int $propertyId
     *
     * @return array|Throwable|object|OrderPropertyType
     * @throws Throwable
     */
    public function getPropertyTypeById($propertyId)
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ORDER_PROPERTY_TYPE, $propertyId));

        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), OrderPropertyType::class, 'json');
    }

    public function getShippingPresets(?string $with = null): array|Throwable
    {
        $options = [];
        if (null !== $with) {
            $options['query'] = ['with' => $with];
        }

        $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::ORDER_SHIPPING_PRESETS, $options);
        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            sprintf('array<%s>', OrderShippingPreset::class),
            'json'
        );
    }

    /**
     * Get Referrers
     *
     * @return Exception|OrderReferrer[]
     */
    public function getReferrers()
    {
        $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::ORDER_REFERRERS);
        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            sprintf('array<%s>', OrderReferrer::class),
            'json'
        );
    }

    /**
     * Get Date Types
     *
     * @return array|Exception|OrderDateType[]
     */
    public function getDateTypes()
    {
        $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::ORDER_DATE_TYPES);
        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize(
            $response->getBody()->getContents(),
            sprintf('array<%s>', OrderDateType::class),
            'json'
        );
    }

    public function postComment(int $orderId, string $comment): bool|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_PUT,
            RestfulUrl::COMMENTS,
            [
                RequestOptions::JSON => [
                    'referenceType' => 'order',
                    'referenceValue' => $orderId,
                    'text' => $comment,
                    'userId' => $_ENV['APP_PLENTY_USER_ID'],
                    'isVisibleForContact' => false,
                ],
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return true;
    }

    /**
     * Put property value
     *
     * @param int $orderId
     * @param int $propertyId
     * @param string $value
     *
     * @return bool|Exception
     */
    public function putProperty($orderId, $propertyId, $value)
    {
        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::ORDER_PROPERTY, $orderId, $propertyId),
            [
                RequestOptions::JSON => [
                    'typeId' => $propertyId,
                    'value' => $value,
                ],
            ]
        );

        if ($response instanceof Exception) {
            return $response;
        }

        return true;
    }

    /**
     * Put Warehouse ID for Order Item
     *
     *
     * @return bool|Exception|mixed
     */
    public function putItemWarehouse(int $orderId, int $orderItemId, int $warehouseApiId)
    {
        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::ORDER, $orderId),
            [
                RequestOptions::JSON => [
                    'orderItems' => [
                        [
                            'id' => $orderItemId,
                            'warehouseId' => $warehouseApiId,
                        ],
                    ],
                ],
            ]
        );

        if ($response instanceof Exception) {
            return $response;
        }

        return true;
    }
}