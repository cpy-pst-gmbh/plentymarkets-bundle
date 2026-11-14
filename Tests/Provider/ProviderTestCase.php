<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PM\PlentyMarketsBundle\Component\Config;
use PM\PlentyMarketsBundle\Tests\Support\MockedRestfulService;
use PM\PlentyMarketsBundle\Tests\Support\Serializers;
use Psr\Http\Message\RequestInterface;
use Throwable;

use function array_map;
use function array_slice;
use function count;
use function file_get_contents;
use function is_array;
use function is_string;
use function json_decode;
use function json_encode;
use function parse_str;

use const JSON_THROW_ON_ERROR;

/**
 * A provider against Guzzle's MockHandler, with the bundle's serializer: the test queues the
 * answers of plentymarkets (respond()) and looks at the requests the provider made (request(),
 * query(), body()). The login is answered in setUp() and is not among them.
 *
 * An answer too few makes the MockHandler throw, and getResponse() hands that back as the
 * result, so a test also checks how many requests there were (assertRequestCount()).
 */
abstract class ProviderTestCase extends TestCase
{
    protected MockedRestfulService $service;

    protected function setUp(): void
    {
        $this->service = new MockedRestfulService($this, Serializers::bundle());
        $this->service->handler->append(new Response(200, [], '{"access_token":"the-token","expires_in":86400}'));
    }

    protected function config(): Config
    {
        return new Config('https://p12345.my.plentysystems.com', 'rest-user', 'geheim', 0.3, 0.2);
    }

    /**
     * Queues answers: an array is sent as JSON with 200, a string as the body with 200, a
     * Response or Throwable as it is.
     */
    protected function respond(array|string|Response|Throwable ...$answers): void
    {
        foreach ($answers as $answer) {
            $this->service->handler->append(match (true) {
                is_array($answer) => new Response(200, ['Content-Type' => 'application/json'], json_encode($answer, JSON_THROW_ON_ERROR)),
                is_string($answer) => new Response(200, [], $answer),
                default => $answer,
            });
        }
    }

    /** @return list<RequestInterface> the requests to plentymarkets, without the login */
    protected function requests(): array
    {
        return array_slice(array_map(static fn (array $entry): RequestInterface => $entry['request'], $this->service->history), 1);
    }

    protected function request(int $index = 0): RequestInterface
    {
        $requests = $this->requests();
        self::assertArrayHasKey($index, $requests, 'There were only '.count($requests).' requests.');

        return $requests[$index];
    }

    /** Method and path of a request, the path from /rest/ on, and its query if given. */
    protected function assertRequest(string $method, string $path, ?array $query = null, int $index = 0): void
    {
        $request = $this->request($index);
        self::assertSame([$method, $path], [$request->getMethod(), $request->getUri()->getPath()]);
        if (null !== $query) {
            self::assertSame($query, $this->query($index));
        }
    }

    protected function assertRequestCount(int $count): void
    {
        self::assertCount($count, $this->requests());
    }

    /** @return array<string, mixed> the query of a request, as PHP reads it (all values strings) */
    protected function query(int $index = 0): array
    {
        parse_str($this->request($index)->getUri()->getQuery(), $query);

        return $query;
    }

    /** The JSON body of a request, decoded. */
    protected function body(int $index = 0): mixed
    {
        return json_decode((string) $this->request($index)->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }

    /** @return array<string, mixed> a generated answer for a model, Tests/Fixtures/<path>.json */
    protected static function fixture(string $path): array
    {
        return json_decode((string) file_get_contents(__DIR__.'/../Fixtures/'.$path.'.json'), true, flags: JSON_THROW_ON_ERROR);
    }
}
