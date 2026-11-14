<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use DateTimeImmutable;
use DateTimeZone;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Model\Category\Category;

/** The categories: all pages of them, and the two ready-made queries for item categories. */
final class CategoryProviderTest extends ProviderTestCase
{
    public function testAllCategoriesOfASinglePageAreReturnedAsModels(): void
    {
        $this->respond(self::page(true, [1, 2]));

        $categories = $this->service->categories($this->config())->getAll();

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/categories', ['page' => '1']);
        self::assertContainsOnlyInstancesOf(Category::class, $categories);
        self::assertSame([1, 2], array_map(static fn (Category $category): int => $category->getId(), $categories));
    }

    public function testEveryFieldOfACategoryIsRead(): void
    {
        $this->respond(['isLastPage' => true, 'entries' => [self::fixture('Model/Category/Category')]]);

        $categories = $this->service->categories($this->config())->getAll();

        self::assertCount(1, $categories);
        self::assertSame(1115, $categories[0]->getId());
        self::assertSame(1116, $categories[0]->getParentCategoryId());
        self::assertSame('value-118', $categories[0]->getType());
        self::assertCount(2, $categories[0]->getDetails());
        self::assertCount(2, $categories[0]->getClients());
    }

    public function testTheFollowingPagesAreFetchedAndMergedInOrder(): void
    {
        $this->respond(self::page(false, [1, 2]), self::page(false, [3]), self::page(true, [4, 5]));

        $categories = $this->service->categories($this->config())->getAll(1, ['type' => 'item']);

        $this->assertRequestCount(3);
        $this->assertRequest('GET', '/rest/categories', ['page' => '1', 'type' => 'item'], 0);
        $this->assertRequest('GET', '/rest/categories', ['page' => '2', 'type' => 'item'], 1);
        $this->assertRequest('GET', '/rest/categories', ['page' => '3', 'type' => 'item'], 2);
        self::assertSame([1, 2, 3, 4, 5], array_map(static fn (Category $category): int => $category->getId(), $categories));
    }

    public function testPagingStartsAtTheGivenPage(): void
    {
        $this->respond(self::page(true, [7]));

        $this->service->categories($this->config())->getAll(4);

        $this->assertRequest('GET', '/rest/categories', ['page' => '4']);
    }

    public function testThePageArgumentWinsOverAPageInTheQuery(): void
    {
        $this->respond(self::page(false, [7]), self::page(true, [8]));

        $this->service->categories($this->config())->getAll(1, ['page' => 9]);

        // Before #60 the query's page won, and every round asked for page 9 again.
        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/categories', ['page' => '1'], 0);
        $this->assertRequest('GET', '/rest/categories', ['page' => '2'], 1);
    }

    public function testAnErrorOnTheFirstPageIsReturned(): void
    {
        $error = ClientException::create(new Request('GET', 'categories'), new Response(404, [], '{"error":"not found"}'));
        $this->respond($error);

        $result = $this->service->categories($this->config())->getAll();

        self::assertSame($error, $result);
    }

    public function testAnErrorOnALaterPageKeepsThePagesBefore(): void
    {
        $this->respond(
            self::page(false, [1, 2]),
            ClientException::create(new Request('GET', 'categories'), new Response(404, [], '{"error":"not found"}')),
        );

        $categories = $this->service->categories($this->config())->getAll();

        $this->assertRequestCount(2);
        self::assertSame([1, 2], array_map(static fn (Category $category): int => $category->getId(), $categories));
    }

    public function testItemCategoriesUpdatedSinceAreAskedForWithTheDayOnly(): void
    {
        $this->respond(self::page(true, [1]));

        $categories = $this->service->categories($this->config())->getAllForItemsUpdatedSince(
            new DateTimeImmutable('2026-03-02 23:30:00', new DateTimeZone('Europe/Berlin')),
        );

        $this->assertRequest('GET', '/rest/categories', ['page' => '1', 'type' => 'item', 'updatedAtAfter' => '2026-03-02']);
        self::assertSame(1, $categories[0]->getId());
    }

    public function testTheDayOfUpdatedSinceIsTakenInTheTimezoneOfTheDate(): void
    {
        $this->respond(self::page(true, [1]));

        $this->service->categories($this->config())->getAllForItemsUpdatedSince(
            new DateTimeImmutable('2026-03-02 23:30:00', new DateTimeZone('UTC')),
        );

        self::assertSame('2026-03-02', $this->query()['updatedAtAfter'], 'Not converted: 00:30 on 3 March in Berlin.');
    }

    public function testItemCategoriesWithoutASinceDateAreAllItemCategories(): void
    {
        $this->respond(self::page(true, [1]));

        $this->service->categories($this->config())->getAllForItemsUpdatedSince();

        $this->assertRequest('GET', '/rest/categories', ['page' => '1', 'type' => 'item']);
    }

    public function testItemCategoriesUpdatedSinceFollowThePages(): void
    {
        $this->respond(self::page(false, [1]), self::page(true, [2]));

        $categories = $this->service->categories($this->config())->getAllForItemsUpdatedSince(new DateTimeImmutable('2026-03-02'));

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/categories', ['page' => '2', 'type' => 'item', 'updatedAtAfter' => '2026-03-02'], 1);
        self::assertSame([1, 2], array_map(static fn (Category $category): int => $category->getId(), $categories));
    }

    public function testItemCategoriesWithClientsAreAskedFor250APage(): void
    {
        $this->respond(self::page(false, [1]), self::page(true, [2]));

        $categories = $this->service->categories($this->config())->getAllForItemsWithClients();

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/categories', ['page' => '1', 'type' => 'item', 'with' => 'clients', 'itemsPerPage' => '250'], 0);
        $this->assertRequest('GET', '/rest/categories', ['page' => '2', 'type' => 'item', 'with' => 'clients', 'itemsPerPage' => '250'], 1);
        self::assertSame([1, 2], array_map(static fn (Category $category): int => $category->getId(), $categories));
    }

    public function testItemCategoriesWithClientsReturnAnError(): void
    {
        $error = ClientException::create(new Request('GET', 'categories'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->categories($this->config())->getAllForItemsWithClients());
    }

    /** @param list<int> $ids */
    private static function page(bool $isLastPage, array $ids): array
    {
        $page = self::fixture('Response/CategoriesResponse');
        $page['isLastPage'] = $isLastPage;
        $page['entries'] = array_map(static fn (int $id): array => ['id' => $id] + $page['entries'][0], $ids);

        return $page;
    }
}
