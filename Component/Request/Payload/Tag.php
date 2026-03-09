<?php

namespace PM\PlentyMarketsBundle\Component\Request\Payload;

use PM\PlentyMarketsBundle\Component\Config\TagType;
use PM\PlentyMarketsBundle\Component\Request\Payload;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;

class Tag
{
    public static function postRelationship(int $tagId, TagType $tagType, string $relationshipValue, string $relationshipUUID5 = ''): Payload
    {
        $payload = new Payload();
        $payload
            ->setResource(RestfulUrl::TAGS_RELATIONSHIPS)
            ->setMethod(Request::METHOD_POST)
            ->setBody(
                [
                    'tagId' => $tagId,
                    'tagType' => $tagType->name,
                    'relationshipValue' => $relationshipValue,
                    'relationshipUUID5' => $relationshipUUID5,
                ]
            );

        return $payload;
    }
}
