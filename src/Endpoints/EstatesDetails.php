<?php

/*
* This file is part of the fw4/whise-api library
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Whise\Api\Endpoints;

use Whise\Api\Endpoint;
use Whise\Api\Request\CollectionRequest;
use Whise\Api\Response\Response;

class EstatesDetails extends Endpoint
{
    /**
     * Request a list of sub-details available to the client.
     *
     * @link https://api.whise.eu/WebsiteDesigner.html#tag/Estates/operation/Estates_GetDetails
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
     * @return CollectionResponse Traversable collection of items
     */
    public function list(?array $parameters = null): Response
    {
        $request = new CollectionRequest('POST', 'v1/estates/details/list', $parameters);
        $request->requireAuthentication(true)->allowGreedyCache(true);
        return new Response($this->getApiAdapter()->request($request));
    }
}
