<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use DateTimeImmutable;
use DateTimeZone;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\Exception\RuntimeException as SerializerRuntimeException;
use PM\PlentyMarketsBundle\Component\Model\Account\Contact;
use PM\PlentyMarketsBundle\Component\Provider\AccountsProvider;
use PM\PlentyMarketsBundle\Component\Response\ContactsResponse;

use function array_map;

use const DATE_ATOM;

/** The contacts of plentymarkets: one, a page, all pages, and writing their fields. */
final class AccountsProviderTest extends ProviderTestCase
{
    public function testAContactIsReadByItsId(): void
    {
        $this->respond(self::fixture('Model/Account/Contact'));

        $contact = $this->provider()->getContact(1018);

        $this->assertRequest('GET', '/rest/accounts/contacts/1018', []);
        self::assertInstanceOf(Contact::class, $contact);
        self::assertSame([1018, 'value-23'], [$contact->getId(), $contact->getLastName()]);
        self::assertSame('2026-03-12T10:39:00+01:00', $contact->getUpdatedAt()->format(DATE_ATOM));
    }

    public function testAContactDoesNotFixTheZeroDateAndThrowsOnIt(): void
    {
        $this->respond(['id' => 1018, 'birthdayAt' => '-0001-11-30T00:00:00+01:00']);

        $this->expectException(SerializerRuntimeException::class);
        $this->expectExceptionMessage('Invalid datetime "-0001-11-30T00:00:00+01:00"');

        $this->provider()->getContact(1018);
    }

    public function testAContactGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getContact(1018));
    }

    public function testTheContactsAreReadFromAllPagesFromTheOneGivenOn(): void
    {
        $this->respond(
            self::page(2, false, [['id' => 1, 'lastName' => 'Arndt'], ['id' => 2, 'lastName' => 'Berg']]),
            self::page(3, false, [['id' => 3, 'lastName' => 'Claus']]),
            self::page(4, true, [['id' => 4, 'lastName' => 'Dahl']]),
        );

        $contacts = $this->provider()->getContacts(2, ['classId' => 3]);

        $this->assertRequestCount(3);
        $this->assertRequest('GET', '/rest/accounts/contacts', ['page' => '2', 'classId' => '3'], 0);
        $this->assertRequest('GET', '/rest/accounts/contacts', ['page' => '3', 'classId' => '3'], 1);
        $this->assertRequest('GET', '/rest/accounts/contacts', ['page' => '4', 'classId' => '3'], 2);
        self::assertContainsOnlyInstancesOf(Contact::class, $contacts);
        self::assertSame([1, 2, 3, 4], array_map(static fn (Contact $contact) => $contact->getId(), $contacts));
        self::assertSame('Dahl', $contacts[3]->getLastName());
    }

    public function testTheContactsAreReadFromTheFirstPageWithoutFilters(): void
    {
        $this->respond(self::fixture('Response/ContactsResponse'), self::page(2, true, []));

        $contacts = $this->provider()->getContacts();

        $this->assertRequestCount(2);
        $this->assertRequest('GET', '/rest/accounts/contacts', ['page' => '1'], 0);
        $this->assertRequest('GET', '/rest/accounts/contacts', ['page' => '2'], 1);
        self::assertContainsOnlyInstancesOf(Contact::class, $contacts);
        self::assertSame([3126, 3170], array_map(static fn (Contact $contact) => $contact->getId(), $contacts));
    }

    public function testTheContactsOfASingleLastPageAreAskedForOnce(): void
    {
        $this->respond(self::page(1, true, [['id' => 1]]));

        $contacts = $this->provider()->getContacts();

        $this->assertRequestCount(1);
        self::assertSame([1], array_map(static fn (Contact $contact) => $contact->getId(), $contacts));
    }

    public function testTheContactsGiveTheErrorOfTheFirstPageBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getContacts());
    }

    public function testTheContactsKeepTheEarlierPagesWhenALaterPageFails(): void
    {
        $this->respond(
            self::page(1, false, [['id' => 1]]),
            self::page(2, false, [['id' => 2]]),
            self::error(404),
        );

        $contacts = $this->provider()->getContacts();

        $this->assertRequestCount(3);
        self::assertSame([1, 2], array_map(static fn (Contact $contact) => $contact->getId(), $contacts), 'The error is logged, not given back.');
    }

    public function testTheContactsGoOnToTheNextPageWhileTheAnswerDoesNotSayItIsTheLast(): void
    {
        $this->respond(['entries' => [['id' => 1]]], ['entries' => [['id' => 2]]], self::error(404));

        $contacts = $this->provider()->getContacts();

        $this->assertRequestCount(3);
        self::assertSame([1, 2], array_map(static fn (Contact $contact) => $contact->getId(), $contacts), 'Without isLastPage it stops only at an error.');
    }

    public function testTheContactsUpdatedSinceADateAreAskedForWithTheDayOnly(): void
    {
        $this->respond(self::page(1, true, [['id' => 1]]));
        $since = new DateTimeImmutable('2026-03-02 00:30:00', new DateTimeZone('Europe/Berlin'));

        $contacts = $this->provider()->getContactsUpdatedSince($since);

        $this->assertRequest('GET', '/rest/accounts/contacts', ['page' => '1', 'itemsPerPage' => '10000', 'updatedAtAfter' => '2026-03-02']);
        self::assertSame([1], array_map(static fn (Contact $contact) => $contact->getId(), $contacts));
    }

    public function testTheContactsUpdatedSinceADateUseTheDayInTheZoneOfTheDateGiven(): void
    {
        $this->respond(self::page(1, true, []));

        $this->provider()->getContactsUpdatedSince(new DateTimeImmutable('2026-03-01T23:30:00-05:00'));

        self::assertSame('2026-03-01', $this->query()['updatedAtAfter'], 'Not converted: in Berlin it is already the 2nd.');
    }

    public function testTheContactsUpdatedSinceNoDateAreThoseSince2020(): void
    {
        $this->respond(self::page(1, true, []));

        $contacts = $this->provider()->getContactsUpdatedSince();

        $this->assertRequest('GET', '/rest/accounts/contacts', ['page' => '1', 'itemsPerPage' => '10000', 'updatedAtAfter' => '2020-01-01']);
        self::assertSame([], $contacts);
    }

    public function testTheContactsUpdatedSinceADateFollowThePages(): void
    {
        $this->respond(self::page(1, false, [['id' => 1]]), self::page(2, true, [['id' => 2]]));

        $contacts = $this->provider()->getContactsUpdatedSince(new DateTimeImmutable('2026-03-02T10:14:00+01:00'));

        $this->assertRequestCount(2);
        self::assertSame(['page' => '2', 'itemsPerPage' => '10000', 'updatedAtAfter' => '2026-03-02'], $this->query(1));
        self::assertSame([1, 2], array_map(static fn (Contact $contact) => $contact->getId(), $contacts));
    }

    public function testTheContactsUpdatedSinceADateGiveTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getContactsUpdatedSince(new DateTimeImmutable('2026-03-02T10:14:00+01:00')));
    }

    public function testAPageOfContactsIsReadWithoutFollowingTheOthers(): void
    {
        $this->respond(self::fixture('Response/ContactsResponse'));

        $result = $this->provider()->getContactsPage(5, ['classId' => 3, 'updatedAtAfter' => '2026-03-02']);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/accounts/contacts', ['page' => '5', 'classId' => '3', 'updatedAtAfter' => '2026-03-02']);
        self::assertInstanceOf(ContactsResponse::class, $result);
        self::assertSame([3117, 3118, false], [$result->getPage(), $result->getTotalsCount(), $result->isIsLastPage()]);
        self::assertContainsOnlyInstancesOf(Contact::class, $result->getEntries());
        self::assertSame([3126, 3170], array_map(static fn (Contact $contact) => $contact->getId(), $result->getEntries()));
    }

    public function testAPageOfContactsIsTheFirstWithoutFilters(): void
    {
        $this->respond(self::page(1, true, []));

        $this->provider()->getContactsPage();

        $this->assertRequest('GET', '/rest/accounts/contacts', ['page' => '1']);
    }

    public function testAPageOfContactsGivesTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->getContactsPage());
    }

    public function testTheFieldsOfAContactArePutAsTheyAreGiven(): void
    {
        $this->respond(['id' => 1018]);

        $result = $this->provider()->putContactFields(1018, ['classId' => 4, 'options' => [['typeId' => 2, 'value' => 'a@b.de']]]);

        self::assertNull($result);
        $this->assertRequest('PUT', '/rest/accounts/contacts/1018', []);
        self::assertSame(['classId' => 4, 'options' => [['typeId' => 2, 'value' => 'a@b.de']]], $this->body());
    }

    public function testTheFieldsOfAContactGiveTheErrorBack(): void
    {
        $error = self::error(404);
        $this->respond($error);

        self::assertSame($error, $this->provider()->putContactFields(1018, ['classId' => 4]));
    }

    private function provider(): AccountsProvider
    {
        return $this->service->accounts($this->config());
    }

    /** @param list<array<string, mixed>> $entries */
    private static function page(int $page, bool $last, array $entries): array
    {
        return ['page' => $page, 'totalsCount' => 99, 'isLastPage' => $last, 'entries' => $entries];
    }

    private static function error(int $status): RequestException
    {
        $error = ClientException::create(new Request('GET', 'https://p12345.my.plentysystems.com/rest/accounts/contacts'), new Response($status, [], '{"error":{"message":"Not found"}}'));
        self::assertInstanceOf(ClientException::class, $error);

        return $error;
    }
}
