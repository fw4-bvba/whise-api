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

final class AdminOffices extends Endpoint
{
    /**
     * Request a list of activated offices.
     *
     * @link http://api.whise.eu/WebsiteDesigner.html#operation/Admin_GetOffices
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
    public function list(?array $parameters = null): CollectionResponse
    {
        $request = new CollectionRequest('POST', 'v1/admin/offices/list', $parameters);
        $request->setResponseKey('offices')->requireAuthentication(true)->allowGreedyCache(true);

        // Check if OfficeIds parameter is present and not empty
        $has_office_ids = false;
        if (isset($parameters)) {
            foreach (array_keys($parameters) as $parameter_key) {
                if (strtolower($parameter_key) === 'officeids') {
                    $has_office_ids = is_array($parameters[$parameter_key]) && count($parameters[$parameter_key]);
                    break;
                }
            }
        }

        // Endpoint does not support pagination if OfficeIds parameter is used
        if ($has_office_ids) {
            return new CollectionResponse($this->getApiAdapter()->request($request));
        } else {
            return new CollectionResponsePaginated($request, $this->getApiAdapter());
        }
    }
}
