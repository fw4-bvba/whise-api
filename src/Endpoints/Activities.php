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

class Activities extends Endpoint
{
    /**
     * Request a list of calendar-type activities.
     *
     * @link https://api.whise.eu/WebsiteDesigner.html#tag/Activity/operation/Activity_GetCalendars
     * Official documentation
     *
     * @param array $filter Associative array containing filter parameters
     * @param array $aggregate Associative array containing aggregation
     * parameters, or an array of fields to aggregate
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return CollectionResponse Traversable collection of items
     */
    public function calendars(?array $filter = null, ?array $aggregate = null): CollectionResponse
    {
        $parameters = $this->getFilterParameters([
            'Filter' => $filter,
            'Aggregate' => $aggregate,
        ]);

        $request = new CollectionRequest('POST', 'v1/activities/calendars', $parameters);
        $request->setResponseKey('activities')->requireAuthentication(true)->allowGreedyCache(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }

    /**
     * Request a list of history-type activities.
     *
     * @link https://api.whise.eu/WebsiteDesigner.html#tag/Activity/operation/Activity_GetHistories
     * Official documentation
     *
     * @param array $filter Associative array containing filter parameters
     * @param array $aggregate Associative array containing aggregation
     * parameters, or an array of fields to aggregate
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return CollectionResponse Traversable collection of items
     */
    public function histories(?array $filter = null, ?array $aggregate = null): CollectionResponse
    {
        $parameters = $this->getFilterParameters([
            'Filter' => $filter,
            'Aggregate' => $aggregate,
        ]);

        $request = new CollectionRequest('POST', 'v1/activities/histories', $parameters);
        $request->setResponseKey('activities')->requireAuthentication(true)->allowGreedyCache(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }

    /**
     * Request a list of data-audit-type activities.
     *
     * @link https://api.whise.eu/WebsiteDesigner.html#tag/Activity/operation/Activity_GetDataChanges
     * Official documentation
     *
     * @param array $filter Associative array containing filter parameters
     * @param array $aggregate Associative array containing aggregation
     * parameters, or an array of fields to aggregate
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return CollectionResponse Traversable collection of items
     */
    public function audits(?array $filter = null, ?array $aggregate = null): CollectionResponse
    {
        $parameters = $this->getFilterParameters([
            'Filter' => $filter,
            'Aggregate' => $aggregate,
        ]);

        $request = new CollectionRequest('POST', 'v1/activities/audits', $parameters);
        $request->setResponseKey('activities')->requireAuthentication(true)->allowGreedyCache(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }

    /**
     * Request a list of history-export-type activities.
     *
     * @link https://api.whise.eu/WebsiteDesigner.html#tag/Activity/operation/Activity_GetHistoryExport
     * Official documentation
     *
     * @param array $filter Associative array containing filter parameters
     * @param array $aggregate Associative array containing aggregation
     * parameters, or an array of fields to aggregate
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return CollectionResponse Traversable collection of items
     */
    public function historyExports(?array $filter = null, ?array $aggregate = null): CollectionResponse
    {
        $parameters = $this->getFilterParameters([
            'Filter' => $filter,
            'Aggregate' => $aggregate,
        ]);

        $request = new CollectionRequest('POST', 'v1/activities/historyexports', $parameters);
        $request->setResponseKey('activities')->requireAuthentication(true)->allowGreedyCache(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }
}
