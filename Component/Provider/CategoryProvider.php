<?php


namespace PM\PlentyMarketsBundle\Component\Provider;


use DateTimeInterface;
use PM\PlentyMarketsBundle\Component\Model\Category\Category;
use PM\PlentyMarketsBundle\Component\Response\CategoriesResponse;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class CategoryProvider extends BaseProvider
{
    /**
     * Get All
     *
     * @param int   $page
     * @param array $query
     *
     * @return Throwable|array|Category[]
     * @throws Throwable
     */
    public function getAll($page = 1, $query = [])
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::CATEGORIES,
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

        /** @var CategoriesResponse $data */
        $data = $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), CategoriesResponse::class, 'json');

        if (true === $data->isIsLastPage()) {
            return $data->getEntries();
        }

        /* Get other pages */
        $merged = $this->getAll($page + 1, $query);
        if ($merged instanceof Throwable) {
            $this->getService()->getLogger()->error(
                'CategoryProvider:getAll got some exception importing more pages',
                [
                    'message' => $merged->getMessage(),
                ]
            );

            $merged = [];
        }

        return array_merge($data->getEntries(), $merged);
    }

    /**
     * Items Updated Since
     *
     *
     * @return array|Category[]|Throwable
     * @throws Throwable
     */
    public function getAllForItemsUpdatedSince(?DateTimeInterface $since = null)
    {
        $query = ['type' => 'item'];

        if (null !== $since) {
            $query['updatedAtAfter'] = $since->format('Y-m-d');
        }

        return $this->getAll(1, $query);
    }

    /**
     * Item categories including their clients
     *
     * @return array|Category[]|Throwable
     * @throws Throwable
     */
    public function getAllForItemsWithClients()
    {
        return $this->getAll(1, ['type' => 'item', 'with' => 'clients', 'itemsPerPage' => 250]);
    }
}