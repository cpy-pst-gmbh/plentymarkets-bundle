<?php

namespace PM\PlentyMarketsBundle\Tests\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PM\PlentyMarketsBundle\Component\Model\Fulfilment\Picklist;
use Throwable;

/** A picklist of the fulfilment, read with the fix for plentymarkets' zero date. */
final class FulfilmentProviderTest extends ProviderTestCase
{
    public function testAPicklistIsFetchedByItsId(): void
    {
        $this->respond(self::fixture('Model/Fulfilment/Picklist'));

        $picklist = $this->service->fulfilment($this->config())->getById(42);

        $this->assertRequestCount(1);
        $this->assertRequest('GET', '/rest/fulfillment/picklist/42', []);
        self::assertInstanceOf(Picklist::class, $picklist);
        self::assertSame(1146, $picklist->getId());
        self::assertSame('value-152', $picklist->getProcessState());
        self::assertSame('2026-03-08T10:27:00+01:00', $picklist->getCreatedAt()->format(DATE_ATOM));
        self::assertSame(['key-154' => 'value-154'], $picklist->getFilterOptions()->getOrderIds());
    }

    public function testTheZeroDateOfAPicklistIsReadAsTheYearZero(): void
    {
        $answer = self::fixture('Model/Fulfilment/Picklist');
        $answer['processDate'] = '-0001-11-30T00:00:00+01:00';
        $answer['doneDate'] = '-0001-11-30T00:00:00+00:53';
        $this->respond($answer);

        $picklist = $this->service->fulfilment($this->config())->getById(42);

        self::assertInstanceOf(Picklist::class, $picklist);
        self::assertSame('-0001-11-30T00:00:00+01:00', $picklist->getProcessDate()->format(DATE_ATOM), 'PHP reads 0000-00-00 as 30 November of the year -1.');
        self::assertSame('-0001-11-30T00:00:00+01:00', $picklist->getDoneDate()->format(DATE_ATOM));
    }

    public function testAnErrorAnswerIsReturned(): void
    {
        $error = ClientException::create(new Request('GET', 'fulfillment/picklist/42'), new Response(404, [], '{"error":"not found"}'));
        $this->respond($error);

        self::assertSame($error, $this->service->fulfilment($this->config())->getById(42));
    }

    public function testAnAnswerThatCannotBeReadIsReturnedAsTheError(): void
    {
        $this->respond('this is no JSON');

        $result = $this->service->fulfilment($this->config())->getById(42);

        self::assertInstanceOf(Throwable::class, $result);
        self::assertNotInstanceOf(Picklist::class, $result);
    }
}
