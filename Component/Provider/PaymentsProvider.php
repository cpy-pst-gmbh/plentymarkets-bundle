<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 13.07.2017
 * Time: 10:43
 */

namespace PM\PlentyMarketsBundle\Component\Provider;

use DateTimeInterface;
use Exception;
use GuzzleHttp\RequestOptions;
use PM\PlentyMarketsBundle\Component\Model\Payment\Payment;
use PM\PlentyMarketsBundle\Component\Model\Payment\PaymentMethod;
use PM\PlentyMarketsBundle\Component\Model\Payment\PaymentOrderRelation;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

use function array_keys;
use function array_map;
use function array_values;
use function sprintf;

/**
 * Class PaymentsProvider
 *
 * @package PM\PlentyMarketsBundle\Component\Provider
 */
class PaymentsProvider extends BaseProvider
{
    /**
     * Get Methods
     *
     * @return Exception|PaymentMethod[]
     */
    public function getMethods()
    {
        $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::PAYMENTS_METHODS);
        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), PaymentMethod::class.'[]', 'json');
    }

    /**
     * Creates a payment, without order. Link it with postOrderRelation() afterwards.
     *
     * The default is a booked, approved payment in the system currency, as a received bank
     * transfer is entered by hand.
     *
     * @param array<int, string> $properties PaymentProperty::TYPE_* => value
     */
    public function postPayment(
        float $amount,
        int $mopId,
        DateTimeInterface $receivedAt,
        array $properties = [],
        string $currency = 'EUR',
        int $status = Payment::STATUS_APPROVED,
        int $transactionType = Payment::TRANSACTION_TYPE_BOOKED,
    ): Throwable|Payment {
        $body = [
            'amount' => $amount,
            'exchangeRatio' => 1,
            'mopId' => $mopId,
            'currency' => $currency,
            'isSystemCurrency' => true,
            'status' => $status,
            'transactionType' => $transactionType,
            'receivedAt' => $receivedAt->format(DATE_ATOM),
            'properties' => array_map(
                static fn (int $typeId, string $value): array => ['typeId' => $typeId, 'value' => $value],
                array_keys($properties),
                array_values($properties),
            ),
        ];

        $response = $this->getResponse(Request::METHOD_POST, RestfulUrl::PAYMENTS, [RequestOptions::JSON => $body]);

        if ($response instanceof Throwable) {
            return $response;
        }

        try {
            return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), Payment::class, 'json');
        } catch (Throwable $throwable) {
            return $throwable;
        }
    }

    /**
     * Links a payment to an order.
     */
    public function postOrderRelation(int $paymentId, int $orderId): Throwable|PaymentOrderRelation
    {
        $response = $this->getResponse(Request::METHOD_POST, sprintf(RestfulUrl::PAYMENT_ORDER_RELATION, $paymentId, $orderId));

        if ($response instanceof Throwable) {
            return $response;
        }

        try {
            return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), PaymentOrderRelation::class, 'json');
        } catch (Throwable $throwable) {
            return $throwable;
        }
    }

    /**
     * The payments of an order, with their properties.
     *
     * @return Throwable|list<Payment>
     */
    public function getByOrderId(int $orderId): Throwable|array
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::PAYMENTS_ORDER, $orderId));

        if ($response instanceof Throwable) {
            return $response;
        }

        try {
            /** @var list<Payment> */
            return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), Payment::class.'[]', 'json');
        } catch (Throwable $throwable) {
            return $throwable;
        }
    }

    /**
     * Removes the link of a payment to its order; the payment stays.
     */
    public function deleteOrderRelation(int $paymentId): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_DELETE, sprintf(RestfulUrl::PAYMENT_ORDER_RELATIONS, $paymentId));

        return $response instanceof Throwable ? $response : null;
    }

    public function deletePayment(int $paymentId): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_DELETE, sprintf(RestfulUrl::PAYMENT, $paymentId));

        return $response instanceof Throwable ? $response : null;
    }
}
