<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Model\Listing\ListingMarket;
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
}
