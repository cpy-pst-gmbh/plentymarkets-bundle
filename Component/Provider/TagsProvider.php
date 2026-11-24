<?php


namespace PM\PlentyMarketsBundle\Component\Provider;

use GuzzleHttp\RequestOptions;
use PM\PlentyMarketsBundle\Component\Config\TagType;
use PM\PlentyMarketsBundle\Component\Model\Tag\Tag;
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

}