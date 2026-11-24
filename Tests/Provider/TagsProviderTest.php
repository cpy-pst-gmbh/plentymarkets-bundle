<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use PM\PlentyMarketsBundle\Component\Model\Tag\TagRelationship;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Config\TagType;
use PM\PlentyMarketsBundle\Component\Model\Tag\Tag;

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

    public function testAllTagsAreReadWithNameAndColour(): void
    {
        $this->respond([
            ['id' => 203, 'tagName' => 'Pflanzenpass', 'color' => '#e93a97', 'createdAt' => '2022-11-03T19:03:44+01:00', 'updatedAt' => '2022-11-03T19:03:44+01:00'],
            ['id' => 324, 'tagName' => 'Pflanzenpass_neu_generieren', 'color' => '#e93a97'],
        ]);

        $tags = $this->service->tags($this->config())->getTags();

        $this->assertRequest('GET', '/rest/tags', []);
        self::assertContainsOnlyInstancesOf(Tag::class, $tags);
        self::assertSame([[203, 'Pflanzenpass', '#e93a97'], [324, 'Pflanzenpass_neu_generieren', '#e93a97']], array_map(static fn (Tag $tag): array => [$tag->getId(), $tag->getTagName(), $tag->getColor()], $tags));
    }

    public function testTheRelationshipsOfARecordAreRead(): void
    {
        $this->respond([
            ['tagId' => 430, 'tagType' => 'variation', 'relationshipValue' => 27303, 'relationshipUUID5' => '', 'createdAt' => '2026-08-25T09:10:48+02:00', 'updatedAt' => '2026-08-25T09:10:48+02:00', 'id' => 9208257],
        ]);

        $relationships = $this->service->tags($this->config())->getRelationships(430, TagType::variation, 27303);

        $this->assertRequest('GET', '/rest/tags/relationships', ['tagId' => '430', 'tagType' => 'variation', 'relationshipValue' => '27303']);
        self::assertContainsOnlyInstancesOf(TagRelationship::class, $relationships);
        self::assertSame([[9208257, 430, 'variation', 27303]], array_map(static fn (TagRelationship $relationship): array => [$relationship->getId(), $relationship->getTagId(), $relationship->getTagType(), $relationship->getRelationshipValue()], $relationships));
    }

    public function testWithoutAValueAllRelationshipsOfTheTypeAreRead(): void
    {
        $this->respond([self::fixture('Model/Tag/TagRelationship'), ['id' => 2, 'relationshipValue' => 6]]);

        $relationships = $this->service->tags($this->config())->getRelationships(459, TagType::order);

        $this->assertRequest('GET', '/rest/tags/relationships', ['tagId' => '459', 'tagType' => 'order']);
        self::assertSame([1047, 6], array_map(static fn (TagRelationship $relationship): ?int => $relationship->getRelationshipValue(), $relationships));
        self::assertSame(['value-48', '2026-03-22T10:49:00+01:00'], [$relationships[0]->getRelationshipUUID5(), $relationships[0]->getCreatedAt()->format(DATE_ATOM)]);
    }

    public function testReadingRelationshipsGivesTheErrorBack(): void
    {
        $error = ClientException::create(new Request('GET', 'tags/relationships'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->tags($this->config())->getRelationships(1, TagType::order));
    }

    public function testARelationshipIsDeletedByItsIdOverV2(): void
    {
        $this->respond(['affectedRows' => 1]);

        self::assertNull($this->service->tags($this->config())->deleteRelationship(9208257));
        $this->assertRequest('DELETE', '/rest/v2/tags/relationships/9208257', []);
    }

    public function testDeletingARelationshipGivesTheErrorBack(): void
    {
        $error = ClientException::create(new Request('DELETE', 'v2/tags/relationships/1'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->tags($this->config())->deleteRelationship(1));
    }

    public function testAnErrorAnswerIsReturned(): void
    {
        $error = ClientException::create(new Request('POST', 'tags/relationships'), new Response(422, [], '{"error":"invalid"}'));
        $this->respond($error);

        self::assertSame($error, $this->service->tags($this->config())->postRelationship(12, TagType::order, '7'));
    }
}
