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

final class EstatesUsedCities extends Endpoint
{
    /**
     * Request a list of cities in use.
     *
     * @link http://api.whise.eu/WebsiteDesigner.html#operation/Estates_GetRegions
     * Official documentation
     *
     * @param array $estate_filter Associative array containing estate filter
     * parameters, or an associative array containing raw request parameters
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return CollectionResponse Traversable collection of items
     */
    public function list(?array $estate_filter = null): CollectionResponse
    {
        $parameters = $this->getFilterParameters([
            'EstateFilter' => $estate_filter,
        ]);
        
        $request = new CollectionRequest('POST', 'v1/estates/usedcities/list', $parameters);
        $request->setResponseKey('usedcities')->requireAuthentication(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }
}
