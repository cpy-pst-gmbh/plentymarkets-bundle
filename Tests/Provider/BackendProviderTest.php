<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Model\Backend\Log;
use PM\PlentyMarketsBundle\Component\Model\Backend\User;
use PM\PlentyMarketsBundle\Component\Provider\BackendProvider;
use PM\PlentyMarketsBundle\Component\Response\LogsResponse;

use function array_map;

/** The backend of plentymarkets: its users and its log. */
final class BackendProviderTest extends ProviderTestCase
{
    public function testTheUsersAreReadAsAList(): void
    {
        $this->respond([self::fixture('Model/Backend/User'), ['id' => 7, 'realName' => 'Lager', 'email' => 'lager@example.org']]);

        $users = $this->provider()->getUsers();

        $this->assertRequest('GET', '/rest/backend/users', []);
        self::assertCount(2, $users);
        self::assertContainsOnlyInstancesOf(User::class, $users);
        self::assertSame(
            [[1099, 'value-100', 'value-101'], [7, 'Lager', 'lager@example.org']],
            array_map(static fn (User $user) => [$user->getId(), $user->getRealName(), $user->getEmail()], $users),
        );
    }

    public function testNoUsersAreAnEmptyList(): void
    {
        $this->respond([]);

        self::assertSame([], $this->provider()->getUsers());
    }

    public function testTheUsersGiveTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getUsers());
    }

    public function testAPageOfTheLogIsAskedForWithTheFiltersGiven(): void
    {
        $this->respond(self::fixture('Response/LogsResponse'));

        $result = $this->provider()->getLogsPage(2, ['integration' => ['Payment'], 'identifier' => ['PayPal', 'Klarna']]);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/logs', ['page' => '2', 'integration' => ['Payment'], 'identifier' => ['PayPal', 'Klarna']]);
        self::assertInstanceOf(LogsResponse::class, $result);
        self::assertSame([3723, 3724, false], [$result->getPage(), $result->getTotalsCount(), $result->isIsLastPage()]);
        self::assertContainsOnlyInstancesOf(Log::class, $result->getEntries());
        self::assertSame(
            [['value-2732', 'value-2735'], ['value-2741', 'value-2744']],
            array_map(static fn (Log $log) => [$log->getIdentifier(), $log->getCode()], $result->getEntries()),
        );
    }

    public function testAPageOfTheLogIsTheFirstWithoutFilters(): void
    {
        $this->respond(['page' => 1, 'totalsCount' => 0, 'isLastPage' => true, 'entries' => []]);

        $result = $this->provider()->getLogsPage();

        $this->assertRequest('GET', '/rest/logs', ['page' => '1']);
        self::assertSame([], $result->getEntries());
    }

    public function testAPageOfTheLogGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getLogsPage());
    }

    private function provider(): BackendProvider
    {
        return $this->service->backend($this->config());
    }

    private static function error(int $status): RequestException
    {
        $error = ClientException::create(new Request('GET', 'https://p12345.my.plentysystems.com/rest/logs'), new Response($status, [], '{"error":{"message":"Not found"}}'));
        self::assertInstanceOf(ClientException::class, $error);

        return $error;
    }
}
