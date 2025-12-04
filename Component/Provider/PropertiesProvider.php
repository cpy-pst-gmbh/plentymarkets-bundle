<?php

namespace PM\PlentyMarketsBundle\Component\Provider;

use GuzzleHttp\RequestOptions;
use PM\PlentyMarketsBundle\Component\Response\PropertiesResponse;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class PropertiesProvider extends BaseProvider
{
    public function getAll(int $page = 1, array $query = []): array|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::PROPERTIES,
            [
                RequestOptions::QUERY => array_merge(
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

        /** @var PropertiesResponse $data */
        $data = $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), PropertiesResponse::class, 'json');

        if (true === $data->isIsLastPage()) {
            return $data->getEntries();
        }

        /* Get other pages */
        $merged = $this->getAll($page + 1, $query);
        if ($merged instanceof Throwable) {
            $this->getService()->getLogger()->error(
                'PropertyProvider:getAll got some exception importing more pages',
                [
                    'message' => $merged->getMessage(),
                ]
            );

            $merged = [];
        }

        return array_merge($data->getEntries(), $merged);
    }

    public function putRelationValue(int $apiId, string $value): bool|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::PROPERTIES_RELATIONS_VALUES_BY_ID, $apiId),
            [
                RequestOptions::JSON => [
                    'lang' => 'de',
                    'value' => $value,
                ],
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return true;
    }

    public function postRelation(int $propertyId, string $relationTypeIdentifier, int $relationTargetId, ?int $selectionRelationId): int|Throwable
    {
        $options = [
            RequestOptions::JSON => [
                'propertyId' => $propertyId,
                'relationTypeIdentifier' => $relationTypeIdentifier,
                'relationTargetId' => $relationTargetId,
                'selectionRelationId' => $selectionRelationId,
            ],
        ];

        $response = $this->getResponse(Request::METHOD_POST, RestfulUrl::PROPERTIES_RELATIONS, $options);
        if ($response instanceof Throwable) {
            return $response;
        }

        $responseJson = json_decode($response->getBody()->getContents(), true);

        return $responseJson['id'];
    }

    public function postRelationValue(int $relationId, string $value): int|Throwable
    {
        $options = [
            RequestOptions::JSON => [
                'propertyRelationId' => $relationId,
                'lang' => 'de',
                'value' => $value,
            ],
        ];

        $response = $this->getResponse(Request::METHOD_POST, RestfulUrl::PROPERTIES_RELATIONS_VALUES, $options);
        if ($response instanceof Throwable) {
            return $response;
        }

        $responseJson = json_decode($response->getBody()->getContents(), true);

        return $responseJson['id'];
    }

}
