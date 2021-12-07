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

final class EstatesOwned extends Endpoint
{
    /**
     * Get the list of estates owned by a contact.
     *
     * @link http://api.whise.eu/WebsiteMedia.html#operation/Estates_GetOwnedEstates
     * Official documentation
     *
     * @param string $contact_username Username of the contact
     * @param string $contact_password Password of the contact
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
    public function list(string $contact_username, string $contact_password, ?array $filter = null, ?array $sort = null, ?array $field = null): CollectionResponse
    {
        $parameters = $this->getFilterParameters([
            'Filter' => $filter,
            'Sort' => $sort,
            'Field' => $field,
        ]);

        $parameters['ContactUsername'] = $contact_username;
        $parameters['ContactPassword'] = $contact_password;

        $request = new CollectionRequest('POST', 'v1/estates/owned/list', $parameters);
        $request->setResponseKey('estates')->requireAuthentication(true)->allowGreedyCache(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }
}
