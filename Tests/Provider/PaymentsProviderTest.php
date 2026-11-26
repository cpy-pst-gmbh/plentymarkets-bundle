<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use DateTimeImmutable;
use PM\PlentyMarketsBundle\Component\Model\Payment\Payment;
use PM\PlentyMarketsBundle\Component\Model\Payment\PaymentMethod;
use PM\PlentyMarketsBundle\Component\Model\Payment\PaymentOrderRelation;
use PM\PlentyMarketsBundle\Component\Model\Payment\PaymentProperty;
use PM\PlentyMarketsBundle\Component\Provider\PaymentsProvider;
use Throwable;

use function array_map;

/** The payment methods and payments of plentymarkets. */
final class PaymentsProviderTest extends ProviderTestCase
{
    public function testThePaymentMethodsAreReadAsAList(): void
    {
        $this->respond([self::fixture('Model/Payment/PaymentMethod'), ['id' => 6000, 'pluginKey' => 'PayPal', 'paymentKey' => 'PAYPAL', 'name' => 'PayPal']]);

        $methods = $this->provider()->getMethods();

        $this->assertRequest('GET', '/rest/payments/methods', []);
        self::assertCount(2, $methods);
        self::assertContainsOnlyInstancesOf(PaymentMethod::class, $methods);
        self::assertSame(
            [[2921, 'value-1922', 'value-1923', 'value-1924'], [6000, 'PayPal', 'PAYPAL', 'PayPal']],
            array_map(static fn (PaymentMethod $method) => [$method->getId(), $method->getPluginKey(), $method->getPaymentKey(), $method->getName()], $methods),
        );
    }

    public function testNoPaymentMethodsAreAnEmptyList(): void
    {
        $this->respond([]);

        self::assertSame([], $this->provider()->getMethods());
    }

    public function testThePaymentMethodsGiveTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getMethods());
    }

    public function testAPaymentIsBookedWithItsProperties(): void
    {
        $this->respond(['id' => 812345, 'amount' => 32.89, 'mopId' => 6000, 'status' => 2, 'transactionType' => 2, 'properties' => [['typeId' => 1, 'value' => 'bank-1']]]);

        $payment = $this->provider()->postPayment(32.89, 6000, new DateTimeImmutable('2026-10-05 00:00:00+02:00'), [
            PaymentProperty::TYPE_TRANSACTION_ID => 'bank-1',
            PaymentProperty::TYPE_BOOKING_TEXT => 'Bestellung 2158402',
            PaymentProperty::TYPE_SENDER_NAME => 'Erika Muster',
        ]);

        $this->assertRequest('POST', '/rest/payments', []);
        self::assertSame([
            'amount' => 32.89,
            'exchangeRatio' => 1,
            'mopId' => 6000,
            'currency' => 'EUR',
            'isSystemCurrency' => true,
            'status' => 2,
            'transactionType' => 2,
            'receivedAt' => '2026-10-05T00:00:00+02:00',
            'properties' => [
                ['typeId' => 1, 'value' => 'bank-1'],
                ['typeId' => 3, 'value' => 'Bestellung 2158402'],
                ['typeId' => 11, 'value' => 'Erika Muster'],
            ],
        ], $this->body());
        self::assertInstanceOf(Payment::class, $payment);
        self::assertSame([812345, 32.89, 'bank-1', null], [$payment->getId(), $payment->getAmount(), $payment->getPropertyValue(PaymentProperty::TYPE_TRANSACTION_ID), $payment->getPropertyValue(PaymentProperty::TYPE_SENDER_IBAN)]);
    }

    public function testABookedPaymentGivesTheErrorBack(): void
    {
        $error = self::error(422);
        $this->respond($error);

        self::assertSame($error, $this->provider()->postPayment(1.0, 6000, new DateTimeImmutable()));
    }

    public function testAnUnreadableAnswerOfABookedPaymentIsAnError(): void
    {
        $this->respond('{"id":');

        self::assertInstanceOf(Throwable::class, $this->provider()->postPayment(1.0, 6000, new DateTimeImmutable()));
    }

    public function testAPaymentIsLinkedToAnOrder(): void
    {
        $this->respond(self::fixture('Model/Payment/PaymentOrderRelation'));

        $relation = $this->provider()->postOrderRelation(812345, 2158402);

        $this->assertRequest('POST', '/rest/payment/812345/order/2158402', []);
        self::assertInstanceOf(PaymentOrderRelation::class, $relation);
        self::assertSame(self::fixture('Model/Payment/PaymentOrderRelation')['orderId'], $relation->getOrderId());
    }

    public function testALinkGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->postOrderRelation(812345, 2158402));
    }

    public function testThePaymentsOfAnOrderAreRead(): void
    {
        $this->respond([self::fixture('Model/Payment/Payment'), ['id' => 812345, 'amount' => 32.89]]);

        $payments = $this->provider()->getByOrderId(2158402);

        $this->assertRequest('GET', '/rest/payments/orders/2158402', []);
        self::assertIsArray($payments);
        self::assertContainsOnlyInstancesOf(Payment::class, $payments);
        self::assertSame([1001, 812345], array_map(static fn (Payment $payment): ?int => $payment->getId(), $payments));
        self::assertContainsOnlyInstancesOf(PaymentProperty::class, $payments[0]->getProperties());
        self::assertSame([], $payments[1]->getProperties());
    }

    public function testAnOrderWithoutPaymentsHasAnEmptyList(): void
    {
        $this->respond([]);

        self::assertSame([], $this->provider()->getByOrderId(2158402));
    }

    public function testTheLinkToTheOrderIsDeleted(): void
    {
        $this->respond([]);

        self::assertNull($this->provider()->deleteOrderRelation(812345));
        $this->assertRequest('DELETE', '/rest/payment/812345/order', []);
    }

    public function testThePaymentIsDeleted(): void
    {
        $this->respond([]);

        self::assertNull($this->provider()->deletePayment(812345));
        $this->assertRequest('DELETE', '/rest/payments/812345', []);
    }

    public function testADeletionGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->deletePayment(812345));
    }

    private function provider(): PaymentsProvider
    {
        return $this->service->payments($this->config());
    }

    private static function error(int $status): RequestException
    {
        $error = ClientException::create(new Request('GET', 'https://p12345.my.plentysystems.com/rest/payments/methods'), new Response($status, [], '{"error":{"message":"Not found"}}'));
        self::assertInstanceOf(ClientException::class, $error);

        return $error;
    }
}
