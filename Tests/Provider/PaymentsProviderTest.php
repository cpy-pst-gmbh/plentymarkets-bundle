<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Model\Payment\PaymentMethod;
use PM\PlentyMarketsBundle\Component\Provider\PaymentsProvider;

use function array_map;

/** The payment methods of plentymarkets. */
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
