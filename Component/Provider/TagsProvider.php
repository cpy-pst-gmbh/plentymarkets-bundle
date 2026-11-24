<?php


namespace PM\PlentyMarketsBundle\Component\Provider;

use GuzzleHttp\RequestOptions;
use PM\PlentyMarketsBundle\Component\Config\TagType;
use PM\PlentyMarketsBundle\Component\Model\Tag\Tag;
use PM\PlentyMarketsBundle\Component\Model\Tag\TagRelationship;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class TagsProvider extends BaseProvider
{
    /**
     * All tags with name and colour, in one list: the route has no pages.
     *
     * @return list<Tag>|Throwable
     */
    public function getTags(): array|Throwable
    {
        $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::TAGS);
        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), Tag::class.'[]', 'json');
    }

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

    /**
     * The relationships of a tag, all of one type or those of one record. The route has no pages.
     *
     * @return list<TagRelationship>|Throwable
     */
    public function getRelationships(int $tagId, TagType $tagType, ?int $relationshipValue = null): array|Throwable
    {
        $query = [
            'tagId' => $tagId,
            'tagType' => $tagType->name,
        ];
        if (null !== $relationshipValue) {
            $query['relationshipValue'] = $relationshipValue;
        }

        $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::TAGS_RELATIONSHIPS, [RequestOptions::QUERY => $query]);
        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), TagRelationship::class.'[]', 'json');
    }

    /**
     * Deletes one relationship by its id (TagRelationship::getId()). The v1 route
     * DELETE tags/{tagId}/relationships/{type}/{x} answers 200 and deletes nothing.
     */
    public function deleteRelationship(int $relationshipId): ?Throwable
    {
        $response = $this->getResponse(Request::METHOD_DELETE, sprintf(RestfulUrl::TAGS_RELATIONSHIP_V2, $relationshipId));

        return $response instanceof Throwable ? $response : null;
    }
}
