<?php

/*
* This file is part of the fw4/whise-api library
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Whise\Api\Endpoints;

use Whise\Api\Endpoint;
use Whise\Api\Request\Request;
use Whise\Api\Request\CollectionRequest;
use Whise\Api\Response\Response;
use Whise\Api\Response\CollectionResponse;
use Whise\Api\Response\CollectionResponsePaginated;

final class Contacts extends Endpoint
{
    /** @var ContactsOrigins */
    protected $originsEndpoint;

    /** @var ContactsTitles */
    protected $titlesEndpoint;

    /** @var ContactsTypes */
    protected $typesEndpoint;

    /**
     * Request a list of contacts.
     *
     * @link http://api.whise.eu/SystemIntegrator.html#operation/Contacts_GetContacts
     * Official documentation
     *
     * @param array $filter Associative array containing filter parameters
     * @param array $sort Associative array containing sorting parameters
     * @param array $field Associative array containing parameters relating to
     * which fields to include or exclude
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return CollectionResponse Traversable collection of items
     */
    public function list(?array $filter = null, ?array $sort = null, ?array $field = null): CollectionResponse
    {
        $parameters = $this->getFilterParameters([
            'Filter' => $filter,
            'Sort' => $sort,
            'Field' => $field,
        ]);

        $request = new CollectionRequest('POST', 'v1/contacts/list', $parameters);
        $request->setResponseKey('contacts')->requireAuthentication(true)->allowGreedyCache(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }

    /**
     * Request a single contact.
     *
     * @param int $id
     * @param array $filter Associative array containing filter parameters
     * @param array $field Associative array containing parameters relating to
     * which fields to include or exclude
     *
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return Response|null
     */
    public function get(int $id, array $filter = [], ?array $field = null): ?Response
    {
        $contacts = $this->list(array_merge([
            'ContactIds' => [$id],
        ], $filter), null, $field)->page(0, 1);

        if (isset($contacts[0])) {
            $response = new Response($contacts[0]);
            $response->transferCacheAttributes($contacts);
            return $response;
        } else {
            return null;
        }
    }

    /**
     * Update, create or remove attributes/subdetails for a given contact ID.
     * To remove the value of an attribute you need to add the attribute in the
     * call and give it the value `null`.
     *
     * @link http://api.whise.eu/SystemIntegrator.html#operation/Contacts_UpdateContact
     * Official documentation
     *
     * @param array $parameters Associative array containing request parameters
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return Response
     */
    public function update(array $parameters): Response
    {
        $parameters = $this->normalizeSearchCriteria($parameters);

        $request = new Request('PATCH', 'v1/contacts/update', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }

    /**
     * Create a contact.
     *
     * @link http://api.whise.eu/WebsiteDesigner.html#operation/Contacts_CreateContact
     * Official documentation
     *
     * @param array $parameters Associative array containing request parameters
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return Response
     */
    public function create(array $parameters): Response
    {
        $parameters = $this->normalizeSearchCriteria($parameters);

        $request = new Request('POST', 'v1/contacts/create', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }


    /**
     * Create or update a contact. When a contact already exists with the same
     * PrivateEmail value, the API will update the existing contact instead.
     *
     * @link http://api.whise.eu/WebsiteDesigner.html#operation/Contacts_UpsertContact
     * Official documentation
     *
     * @param array $parameters Associative array containing request parameters
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return Response
     */
    public function upsert(array $parameters): Response
    {
        $parameters = $this->normalizeSearchCriteria($parameters);

        $request = new Request('POST', 'v1/contacts/upsert', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }


    /**
     * Delete one or more contacts within a list of ID's.
     *
     * @link http://api.whise.eu/SystemIntegrator.html#operation/Contacts_DeleteContact
     * Official documentation
     *
     * @param int|array $parameters Associative array containing request
     * parameters, or an array containing contact ID's, or a single contact ID
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return Response
     */
    public function delete($parameters): Response
    {
        if (is_array($parameters)) {
            if (!$this->arrayIsAssociative($parameters)) {
                $parameters = [
                    'ContactIds' => $parameters,
                ];
            }
        } else {
            $parameters = [
                'ContactIds' => [intval($parameters)],
            ];
        }

        $request = new Request('DELETE', 'v1/contacts/delete', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }

    /**
     * Parse contact parameters and make sure that SearchCriteria is an indexed
     * array.
     *
     * @param array $parameters Associative array containing request parameters
     *
     * @return array
     */
    protected function normalizeSearchCriteria(array $parameters): array
    {
        // Case insensitive parameter key check without modifying casing
        foreach ($parameters as $key => &$value) {
            if (strtolower($key) === 'searchcriteria') {
                if (is_array($value) && $this->arrayIsAssociative($value)) {
                    $parameters[$key] = [$value];
                }
                break;
            }
        }
        return $parameters;
    }

    /**
     * Access endpoints related to contact origins.
     *
     * @return ContactsOrigins
     */
    public function origins(): ContactsOrigins
    {
        if (is_null($this->originsEndpoint)) {
            $this->originsEndpoint = new ContactsOrigins($this->api);
        }
        return $this->originsEndpoint;
    }

    /**
     * Access endpoints related to contact titles.
     *
     * @return ContactsTitles
     */
    public function titles(): ContactsTitles
    {
        if (is_null($this->titlesEndpoint)) {
            $this->titlesEndpoint = new ContactsTitles($this->api);
        }
        return $this->titlesEndpoint;
    }

    /**
     * Access endpoints related to contact types.
     *
     * @return ContactsTypes
     */
    public function types(): ContactsTypes
    {
        if (is_null($this->typesEndpoint)) {
            $this->typesEndpoint = new ContactsTypes($this->api);
        }
        return $this->typesEndpoint;
    }
}
