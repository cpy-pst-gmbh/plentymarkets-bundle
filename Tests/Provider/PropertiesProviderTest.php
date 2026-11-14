<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Model\Property\Property;
use PM\PlentyMarketsBundle\Component\Model\Property\PropertyName;

/** The properties and their relations; the paths of this provider start with /rest/ themselves. */
final class PropertiesProviderTest extends ProviderTestCase
{
    public function testAllPropertiesOfASinglePageAreReturnedAsModels(): void
    {
        $this->respond(self::fixture('Response/PropertiesResponse'));

        $properties = $this->service->properties($this->config())->getAll();

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/properties', ['page' => '1']);
        self::assertContainsOnlyInstancesOf(Property::class, $properties);
        self::assertSame([3913, 3922], array_map(static fn (Property $property): ?int => $property->getId(), $properties));
    }

    public function testEveryFieldOfAPropertyIsRead(): void
    {
        $this->respond(['isLastPage' => true, 'entries' => [self::fixture('Model/Property/Property')]]);

        $property = $this->service->properties($this->config())->getAll()[0];

        self::assertSame(2925, $property->getId());
        self::assertSame(2926, $property->getPropertyId());
        self::assertSame('value-1927', $property->getCast());
        self::assertSame('value-1928', $property->getTypeIdentifier());
        self::assertSame(2929, $property->getPropertyGroupId());
        self::assertContainsOnlyInstancesOf(PropertyName::class, $property->getNames());
        self::assertSame(2932, $property->getNames()[0]->getId());
    }

    public function testTheFollowingPagesAreFetchedAndMergedInOrder(): void
    {
        $this->respond(self::page(false, [1, 2]), self::page(true, [3]));

        $properties = $this->service->properties($this->config())->getAll(1, ['with' => 'names']);

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/properties', ['page' => '1', 'with' => 'names'], 0);
        $this->assertRequest('GET', '/rest/properties', ['page' => '2', 'with' => 'names'], 1);
        self::assertSame([1, 2, 3], array_map(static fn (Property $property): ?int => $property->getId(), $properties));
    }

    public function testThePageArgumentWinsOverAPageInTheQuery(): void
    {
        $this->respond(self::page(false, [1]), self::page(true, [2]));

        $this->service->properties($this->config())->getAll(1, ['page' => 6]);

        // Before #60 the query's page won, and every round asked for page 6 again.
        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/properties', ['page' => '1'], 0);
        $this->assertRequest('GET', '/rest/properties', ['page' => '2'], 1);
    }

    public function testAnErrorOnTheFirstPageIsReturned(): void
    {
        $error = ClientException::create(new Request('GET', '/rest/properties'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->properties($this->config())->getAll());
    }

    public function testAnErrorOnALaterPageKeepsThePagesBefore(): void
    {
        $this->respond(self::page(false, [1, 2]), ClientException::create(new Request('GET', '/rest/properties'), new Response(404, [], '{}')));

        $properties = $this->service->properties($this->config())->getAll();

        $this->assertRequestCount(2);
        self::assertSame([1, 2], array_map(static fn (Property $property): ?int => $property->getId(), $properties));
    }

    public function testARelationValueIsChangedInGerman(): void
    {
        $this->respond(self::fixture('Model/Property/RelationValue'));

        $result = $this->service->properties($this->config())->putRelationValue(77, 'Rot');

        self::assertTrue($result);
        $this->assertRequestCount(1);
        $this->assertRequest('PUT', '/rest/properties/relations/values/77', []);
        self::assertSame(['lang' => 'de', 'value' => 'Rot'], $this->body());
    }

    public function testChangingARelationValueReturnsTheError(): void
    {
        $error = ClientException::create(new Request('PUT', '/rest/properties/relations/values/77'), new Response(404, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->properties($this->config())->putRelationValue(77, 'Rot'));
    }

    public function testARelationIsCreatedAndItsIdReturned(): void
    {
        $this->respond(['id' => 991, 'propertyId' => 5]);

        $id = $this->service->properties($this->config())->postRelation(5, 'item', 1234, 88);

        self::assertSame(991, $id);
        $this->assertRequestCount(1);
        $this->assertRequest('POST', '/rest/properties/relations', []);
        self::assertSame(
            ['propertyId' => 5, 'relationTypeIdentifier' => 'item', 'relationTargetId' => 1234, 'selectionRelationId' => 88],
            $this->body(),
        );
    }

    public function testARelationWithoutSelectionSendsNull(): void
    {
        $this->respond(['id' => 991]);

        $this->service->properties($this->config())->postRelation(5, 'item', 1234, null);

        self::assertSame(
            ['propertyId' => 5, 'relationTypeIdentifier' => 'item', 'relationTargetId' => 1234, 'selectionRelationId' => null],
            $this->body(),
        );
    }

    public function testCreatingARelationReturnsTheError(): void
    {
        $error = ClientException::create(new Request('POST', '/rest/properties/relations'), new Response(422, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->properties($this->config())->postRelation(5, 'item', 1234, null));
    }

    public function testARelationValueIsCreatedInGermanAndItsIdReturned(): void
    {
        $this->respond(['id' => 4711, 'propertyRelationId' => 991]);

        $id = $this->service->properties($this->config())->postRelationValue(991, 'Blau');

        self::assertSame(4711, $id);
        $this->assertRequestCount(1);
        $this->assertRequest('POST', '/rest/properties/relations/values', []);
        self::assertSame(['propertyRelationId' => 991, 'lang' => 'de', 'value' => 'Blau'], $this->body());
    }

    public function testCreatingARelationValueReturnsTheError(): void
    {
        $error = ClientException::create(new Request('POST', '/rest/properties/relations/values'), new Response(422, [], '{}'));
        $this->respond($error);

        self::assertSame($error, $this->service->properties($this->config())->postRelationValue(991, 'Blau'));
    }

    /** @param list<int> $ids */
    private static function page(bool $isLastPage, array $ids): array
    {
        $page = self::fixture('Response/PropertiesResponse');
        $page['isLastPage'] = $isLastPage;
        $page['entries'] = array_map(static fn (int $id): array => ['id' => $id] + $page['entries'][0], $ids);

        return $page;
    }
}
