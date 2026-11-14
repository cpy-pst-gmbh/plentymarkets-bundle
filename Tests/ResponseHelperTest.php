<?php

namespace PM\PlentyMarketsBundle\Tests;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PM\PlentyMarketsBundle\Component\Helper\ResponseHelper;

/** The error text of a failed request, under Guzzle 7 and 8 alike (#53). */
final class ResponseHelperTest extends TestCase
{
    public function testAnErrorOfTheApiIsTakenFromItsAnswer(): void
    {
        // Each helper reads the body to its end, so each gets an exception of its own.
        $notFound = static fn (): ClientException => ClientException::create(new Request('GET', 'https://p1.my.plentysystems.com/rest/orders/1'), new Response(404, [], '{"error":{"code":404,"message":"Resource not found."}}'));

        self::assertSame('Error Code 404', ResponseHelper::getErrorString($notFound()));
        self::assertTrue(ResponseHelper::isResourceNotFoundException($notFound()));
    }

    public function testAnAnswerWithoutJsonSaysSo(): void
    {
        $exception = ClientException::create(new Request('GET', 'https://p1.my.plentysystems.com/rest/orders/1'), new Response(400, [], 'Bad Request'));

        self::assertSame('No valid API response', ResponseHelper::getErrorString($exception));
    }

    public function testAFailureWithoutAnswerGivesItsMessage(): void
    {
        $exception = new ConnectException('Connection refused', new Request('GET', 'https://p1.my.plentysystems.com/rest/orders/1'));

        self::assertSame('Connection refused', ResponseHelper::getErrorString($exception));
    }
}
