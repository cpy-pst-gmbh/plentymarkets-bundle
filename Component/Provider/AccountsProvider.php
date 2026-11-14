<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 05.09.2017
 * Time: 14:52
 */

namespace PM\PlentyMarketsBundle\Component\Provider;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use GuzzleHttp\RequestOptions;
use PM\PlentyMarketsBundle\Component\Model\Account\Contact;
use PM\PlentyMarketsBundle\Component\Response\ContactsResponse;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;
use Throwable;


/**
 * Class AccountsProvider
 *
 * @package PM\PlentyMarketsBundle\Component\Provider
 */
class AccountsProvider extends BaseProvider
{
    /**
     * Get Variation
     *
     * @param int $contactId
     *
     * @return array|Exception|object|Contact
     */
    public function getContact($contactId)
    {
        $response = $this->getResponse(Request::METHOD_GET, sprintf(RestfulUrl::ACCOUNT_CONTACT, $contactId));
        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), Contact::class, 'json');
    }

    /**
     * Get Contacts
     *
     *
     * @return array|Exception|mixed|Contact[]
     */
    public function getContacts(int $page = 1, array $query = [])
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::ACCOUNT_CONTACTS,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ],
                    $query,
                    // The page of the argument, whatever $query says (#60).
                    ['page' => $page]
                ),
            ]
        );

        if ($response instanceof Exception) {
            return $response;
        }

        /** @var ContactsResponse $data */
        $data = $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ContactsResponse::class, 'json');

        if (true === $data->isIsLastPage()) {
            return $data->getEntries();
        }

        /* Get other pages */
        $merged = $this->getContacts($page + 1, $query);
        if ($merged instanceof Exception) {
            $this->getService()->getLogger()->error(
                'AccountsProvider:getContacts got some exception importing more pages',
                [
                    'message' => $merged->getMessage(),
                ]
            );

            $merged = [];
        }

        return array_merge($data->getEntries(), $merged);
    }


    /**
     * Get Contacts (Updated Since Date)
     *
     *
     * @return array|Exception|mixed|Contact[]
     * @throws Exception
     */
    public function getContactsUpdatedSince(?DateTimeInterface $since = null)
    {
        $query = [
            'itemsPerPage' => 10000,
        ];

        if (null !== $since) {
            // plentymarkets takes a day only (yyyy-mm-dd). The day before that of $since, so that
            // no change is missed, whatever zone plentymarkets compares in and whether it counts
            // the day itself (#61); a contact changed that day comes once more.
            $query['updatedAtAfter'] = DateTimeImmutable::createFromInterface($since)->modify('-1 day')->format('Y-m-d');
        } else {
            $query['updatedAtAfter'] = '2020-01-01';
        }

        return $this->getContacts(1, $query);
    }

    /**
     * One page of contacts, filters such as classId or updatedAtAfter go in $query.
     */
    public function getContactsPage(int $page = 1, array $query = []): ContactsResponse|Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_GET,
            RestfulUrl::ACCOUNT_CONTACTS,
            [
                'query' => array_merge(
                    [
                        'page' => $page,
                    ],
                    $query,
                    // The page of the argument, whatever $query says (#60).
                    ['page' => $page]
                ),
            ]
        );

        if ($response instanceof Throwable) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), ContactsResponse::class, 'json');
    }

    /**
     * @param array<string, mixed> $fields
     */
    public function putContactFields(int $contactId, array $fields): ?Throwable
    {
        $response = $this->getResponse(
            Request::METHOD_PUT,
            sprintf(RestfulUrl::ACCOUNT_CONTACT, $contactId),
            [
                RequestOptions::JSON => $fields,
            ]
        );

        return $response instanceof Throwable ? $response : null;
    }
}
