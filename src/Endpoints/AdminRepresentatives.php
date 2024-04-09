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
use Whise\Api\Response\CollectionResponse;
use Whise\Api\Response\CollectionResponsePaginated;

final class AdminRepresentatives extends Endpoint
{
    /**
     * @internal
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
    public function list(?array $parameters = null): CollectionResponse
    {
        $request = new CollectionRequest('POST', 'v1/admin/representatives/list', $parameters);
        $request->setResponseKey('representatives')->requireAuthentication(true)->allowGreedyCache(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }
}
