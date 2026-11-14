<?php


namespace PM\PlentyMarketsBundle\Component\Provider;

use PM\PlentyMarketsBundle\Component\Model\Backend\User;
use PM\PlentyMarketsBundle\Component\Response\LogsResponse;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

/**
 * Class BackendProvider
 *
 * @package PM\PlentyMarketsBundle\Component\Provider
 */
class BackendProvider extends BaseProvider
{

    /**
     * Get Users
     *
     * @return array|User[]|Throwable
     * @throws Throwable
     */
    public function getUsers()
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::BACKEND_USERS
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), User::class.'[]', 'json');
    }

    /**
     * One page of the plenty log. Filters such as integration[] and identifier[] go in $query.
     */
    public function getLogsPage(int $page = 1, array $query = []): LogsResponse|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::LOGS,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ],
                    $query,
                    // The page of the argument, whatever $query says (#60).
                    ['page' => $page]
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), LogsResponse::class, 'json');
    }
}
