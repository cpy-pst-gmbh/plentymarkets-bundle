<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Config\TagType;

/** Tagging something in plentymarkets. */
final class TagsProviderTest extends ProviderTestCase
{
    public function testATagIsRelatedByTheNameOfItsType(): void
    {
        $this->respond(['id' => 5]);

        $result = $this->service->tags($this->config())->postRelationship(12, TagType::variation, '3456', 'a-uuid');

        self::assertNull($result);
        $this->assertRequestCount(1);
        $this->assertRequest('POST', '/rest/tags/relationships', []);
        self::assertSame(
            ['tagId' => 12, 'tagType' => 'variation', 'relationshipValue' => '3456', 'relationshipUUID5' => 'a-uuid'],
            $this->body(),
        );
    }

    public function testTheTypeIsSentAsTheCaseNameWithItsUnderscore(): void
    {
        $this->respond('');

        $this->service->tags($this->config())->postRelationship(12, TagType::content_page, '7');

        self::assertSame('content_page', $this->body()['tagType']);
    }

    public function testWithoutAUuidAnEmptyOneIsSent(): void
    {
        $this->respond('');

        $this->service->tags($this->config())->postRelationship(12, TagType::order, '7');

        self::assertSame(['tagId' => 12, 'tagType' => 'order', 'relationshipValue' => '7', 'relationshipUUID5' => ''], $this->body());
    }

    public function testAnErrorAnswerIsReturned(): void
    {
        $error = ClientException::create(new Request('POST', 'tags/relationships'), new Response(422, [], '{"error":"invalid"}'));
        $this->respond($error);

        self::assertSame($error, $this->service->tags($this->config())->postRelationship(12, TagType::order, '7'));
    }
}
