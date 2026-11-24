<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Model\Backend\DeleteLog;
use PM\PlentyMarketsBundle\Component\Model\Backend\Log;
use PM\PlentyMarketsBundle\Component\Model\Backend\User;
use PM\PlentyMarketsBundle\Component\Provider\BackendProvider;
use PM\PlentyMarketsBundle\Component\Response\DeleteLogResponse;
use PM\PlentyMarketsBundle\Component\Response\LogsResponse;

use function array_map;

/** The backend of plentymarkets: its users, its log and its delete log. */
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

    public function testAPageOfTheDeleteLogIsReadWithItsFilters(): void
    {
        $this->respond(self::fixture('Response/DeleteLogResponse'));

        $result = $this->provider()->getDeleteLogPage(3, ['referenceType' => DeleteLog::REFERENCE_TYPE_ORDER, 'updatedBetween' => '1761868800', 'itemsPerPage' => 250, 'page' => 9]);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/delete_log', ['referenceType' => '3', 'updatedBetween' => '1761868800', 'itemsPerPage' => '250', 'page' => '3']);
        self::assertInstanceOf(DeleteLogResponse::class, $result);
        self::assertSame([1006, 1007, true], [$result->getPage(), $result->getTotalsCount(), $result->isIsLastPage()]);
        self::assertContainsOnlyInstancesOf(DeleteLog::class, $result->getEntries());
        self::assertSame(
            [[1015, 1016, 'value-17', 1018, 'value-19'], [1021, 1022, 'value-23', 1024, 'value-25']],
            array_map(static fn (DeleteLog $log) => [$log->getReferenceType(), $log->getReferenceValue(), $log->getUpdatedAt(), $log->getUserId(), $log->getUserRealName()], $result->getEntries()),
        );
    }

    /** As plenty answered on 24.11.2026: itemsPerPage as string, the date without zone. */
    public function testAPageOfTheDeleteLogIsReadAsPlentySendsIt(): void
    {
        $this->respond('{"page":1,"totalsCount":78,"isLastPage":false,"lastPageNumber":16,"firstOnPage":1,"lastOnPage":5,"itemsPerPage":"5","entries":[{"referenceType":3,"referenceValue":1992783,"updatedAt":"2026-10-31 11:56:36","userId":50,"userRealName":"Tobias Rimbach"}]}');

        $result = $this->provider()->getDeleteLogPage();

        $this->assertRequest('GET', '/rest/delete_log', ['page' => '1']);
        self::assertInstanceOf(DeleteLogResponse::class, $result);
        self::assertSame([16, 5, false], [$result->getLastPageNumber(), $result->getItemsPerPage(), $result->isIsLastPage()]);
        self::assertSame(
            [[3, 1992783, '2026-10-31 11:56:36', 50, 'Tobias Rimbach']],
            array_map(static fn (DeleteLog $log) => [$log->getReferenceType(), $log->getReferenceValue(), $log->getUpdatedAt(), $log->getUserId(), $log->getUserRealName()], $result->getEntries()),
        );
    }

    public function testAPageOfTheDeleteLogGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getDeleteLogPage());
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
