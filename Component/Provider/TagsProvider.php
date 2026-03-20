<?php


namespace PM\PlentyMarketsBundle\Component\Provider;

use GuzzleHttp\RequestOptions;
use PM\PlentyMarketsBundle\Component\Config\TagType;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class TagsProvider extends BaseProvider
{

    public function postRelationship(int $tagId, TagType $tagType, string $relationshipValue, string $relationshipUUID5 = ''): ?Throwable
    {
        $options = [
            RequestOptions::JSON => [
                'tagId'             => $tagId,
                'tagType'           => $tagType->name,
                'relationshipValue' => $relationshipValue,
                'relationshipUUID5' => $relationshipUUID5,
            ],
        ];

        $response = $this->getResponse(Request::METHOD_POST, RestfulUrl::TAGS_RELATIONSHIPS, $options);

        if ($response instanceof Throwable) {
            return $response;
        }

        return null;
    }

}