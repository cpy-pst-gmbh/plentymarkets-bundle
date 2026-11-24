<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Model\Listing\ListingMarket;
use PM\PlentyMarketsBundle\Component\Model\Listing\ListingMarketHistory;
use PM\PlentyMarketsBundle\Component\Response\ListingMarketHistoriesResponse;
use PM\PlentyMarketsBundle\Component\Response\ListingMarketsResponse;

/** One page of the market listings, the caller pages itself. */
final class ListingsProviderTest extends ProviderTestCase
{
    public function testTheFirstPageOfTheMarketListingsIsReturnedAsItIs(): void
    {
        $this->respond(self::fixture('Response/ListingMarketsResponse'));

        $page = $this->service->listings($this->config())->getMarketsPage();

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/listings/markets', ['page' => '1']);
        self::assertInstanceOf(ListingMarketsResponse::class, $page);
        self::assertSame(3631, $page->getPage());
        self::assertFalse($page->isIsLastPage());
        self::assertContainsOnlyInstancesOf(ListingMarket::class, $page->getEntries());
        self::assertSame([3640, 3647], array_map(static fn (ListingMarket $market): ?int => $market->getId(), $page->getEntries()));
    }

    public function testOnlyTheAskedPageIsFetchedEvenIfMoreFollow(): void
    {
        $this->respond(self::fixture('Response/ListingMarketsResponse'));

        $this->service->listings($this->config())->getMarketsPage(3, ['variationId' => 1234, 'marketId' => 4]);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/listings/markets', ['page' => '3', 'variationId' => '1234', 'marketId' => '4']);
    }

    public function testEveryFieldOfAMarketListingIsRead(): void
    {
        $this->respond(['page' => 1, 'isLastPage' => true, 'entries' => [self::fixture('Model/Listing/ListingMarket')]]);

        $market = $this->service->listings($this->config())->getMarketsPage()->getEntries()[0];

        self::assertSame(2395, $market->getId());
        self::assertSame(2396, $market->getListingId());
        self::assertSame(2397, $market->getVariationId());
        self::assertSame(2398.25, $market->getReferrerId());
        self::assertFalse($market->isEnabled());
        self::assertSame('value-1400', $market->getVerified());
    }

    public function testAnErrorAnswerIsReturned(): void
    {
        $error = ClientException::create(new Request('GET', 'listings/markets'), new Response(404, [], '{"error":"not found"}'));
        $this->respond($error);

        self::assertSame($error, $this->service->listings($this->config())->getMarketsPage());
    }

    public function testAPageOfTheMarketHistoriesIsRead(): void
    {
        $this->respond(self::fixture('Response/ListingMarketHistoriesResponse'));

        $page = $this->service->listings($this->config())->getMarketHistoriesPage(2, ['itemsPerPage' => 250, 'page' => 9]);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/listings/markets/histories', ['page' => '2', 'itemsPerPage' => '250']);
        self::assertInstanceOf(ListingMarketHistoriesResponse::class, $page);
        self::assertTrue($page->isIsLastPage());
        self::assertContainsOnlyInstancesOf(ListingMarketHistory::class, $page->getEntries());
        self::assertSame([1025, 1041], array_map(static fn (ListingMarketHistory $history): ?int => $history->getId(), $page->getEntries()));
    }

    public function testEveryFieldOfAMarketHistoryIsRead(): void
    {
        $this->respond(['page' => 1, 'isLastPage' => true, 'entries' => [self::fixture('Model/Listing/ListingMarketHistory')]]);

        $history = $this->service->listings($this->config())->getMarketHistoriesPage()->getEntries()[0];

        self::assertSame([1001, 1002, 1003.25, 'value-4', 1009, 1010.25, 'value-11', 'value-13'], [$history->getId(), $history->getListingMarketId(), $history->getReferrerId(), $history->getExternalId(), $history->getStatusId(), $history->getPrice(), $history->getSku(), $history->getCurrency()]);
        self::assertSame([1005.25, 1006.25, 1007.25, 1008.25, 1012], [$history->getQuantity(), $history->getQuantityRemain(), $history->getQuantitySold(), $history->getQuantitySoldDelta(), $history->getHasStockReservationForEbay()]);
        self::assertSame(['2026-03-15 10:14:00', '2026-03-16 10:15:00'], [$history->getCreatedAt()->format('Y-m-d H:i:s'), $history->getUpdatedAt()->format('Y-m-d H:i:s')], 'The dates come without T and zone.');
    }

    public function testMarketHistoriesGiveTheErrorBack(): void
    {
        $error = ClientException::create(new Request('GET', 'listings/markets/histories'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->listings($this->config())->getMarketHistoriesPage());
    }
}
