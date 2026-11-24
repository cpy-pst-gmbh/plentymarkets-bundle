<?php


namespace PM\PlentyMarketsBundle\Component\Provider;

use PM\PlentyMarketsBundle\Component\Model\Backend\User;
use PM\PlentyMarketsBundle\Component\Response\DeleteLogResponse;
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

    /**
     * One page of the delete log. Filters such as referenceType (DeleteLog::REFERENCE_TYPE_*),
     * userId, updatedBetween ("from,to" as unix timestamps or ISO 8601) and itemsPerPage go in
     * $query. Plenty sorts by the ID of the deleted record, not by date.
     */
    public function getDeleteLogPage(int $page = 1, array $query = []): DeleteLogResponse|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::DELETE_LOG,
            [
                'query' => array_merge($query, ['page' => $page]),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), DeleteLogResponse::class, 'json');
    }
}
