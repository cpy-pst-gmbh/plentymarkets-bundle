<?php

namespace PM\PlentyMarketsBundle\Tests;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PM\PlentyMarketsBundle\Tests\Support\MockedRestfulService;

/**
 * The login: the credentials go in the body, so that no URL holds the password (#55), and the
 * answer is read without Guzzle's json_decode(), which Guzzle 8 no longer has (#53).
 */
final class LoginTest extends TestCase
{
    private const string URI = 'https://p12345.my.plentysystems.com/rest/';

    public function testTheCredentialsGoInTheBodyNotTheUrl(): void
    {
        $service = new MockedRestfulService($this);
        $service->handler->append(new Response(200, [], '{"token_type":"Bearer","expires_in":86400,"access_token":"the-token"}'));

        $token = $service->getAccessToken(self::URI, 'rest-user', 'geheim&mehr');

        self::assertSame('the-token', $token);
        $request = $service->history[0]['request'];
        self::assertSame('POST', $request->getMethod());
        self::assertSame('https://p12345.my.plentysystems.com/rest/login', (string) $request->getUri());
        self::assertSame('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));
        self::assertSame('username=rest-user&password=geheim%26mehr', (string) $request->getBody());
    }

    public function testARefusedLoginNamesNoPassword(): void
    {
        $service = new MockedRestfulService($this);
        $service->handler->append(new Response(401, [], '{"error":"invalid_credentials"}'));

        $response = $service->getLoginResponse(self::URI, 'rest-user', 'geheim');

        self::assertInstanceOf(ClientException::class, $response);
        self::assertStringNotContainsString('geheim', $response->getMessage());
    }

    public function testAnAnswerWithoutJsonIsAnError(): void
    {
        $service = new MockedRestfulService($this);
        $service->handler->append(new Response(200, [], '<html>Wartung</html>'));

        $this->expectException(\JsonException::class);
        $service->getAccessToken(self::URI, 'rest-user', 'geheim');
    }
}
