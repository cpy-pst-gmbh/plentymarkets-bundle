<?php

namespace PM\PlentyMarketsBundle\Component\Provider;

use PM\PlentyMarketsBundle\Component\Response\ListingMarketsResponse;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class ListingsProvider extends BaseProvider
{
    /**
     * A single page of the market listings, for example to find the eBay listing of a variation.
     */
    public function getMarketsPage(int $page = 1, array $query = []): ListingMarketsResponse|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::LISTING_MARKETS,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ],
                    $query
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ListingMarketsResponse::class, 'json');
    }
}
