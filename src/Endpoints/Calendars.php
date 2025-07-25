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

class Calendars extends Endpoint
{
    /** @var CalendarsActions */
    protected $actionsEndpoint;

    /**
     * Request a list of calendar events.
     *
     * @link https://api.whise.eu/WebsiteDesigner.html#tag/Calendars/operation/Calendars_GetCalendars
     * Official documentation
     *
     * @param array $filter Associative array containing filter parameters
     * @param array $sort Associative array containing sorting parameters
     * @param array $field Associative array containing parameters relating to
     * which fields to include or exclude
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
    public function list(
        ?array $filter = null,
        ?array $sort = null,
        ?array $field = null,
        ?array $aggregate = null
    ): CollectionResponse {

        // Whise does not consistently sort calendar items in the response by default,
        // causing issues with pagination. We'll set a default sorting order to prevent this.
        if (is_null($sort)) {
            $sort = [[
                'Field' => 'startDateTime',
                'Ascending' => true,
            ],[
                'Field' => 'id',
                'Ascending' => true,
            ]];
        }

        $parameters = $this->getFilterParameters([
            'Filter' => $filter,
            'Sort' => $sort,
            'Field' => $field,
            'Aggregate' => $aggregate,
        ]);

        $request = new CollectionRequest('POST', 'v1/calendars/list', $parameters);
        $request->setResponseKey('calendars')->requireAuthentication(true)->allowGreedyCache(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }

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
     * @return Response
     */
    public function create(array $parameters): Response
    {
        $request = new Request('POST', 'v1/calendars/create', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }

    /**
     * Delete a calendar event.
     *
     * @link https://api.whise.eu/WebsiteDesigner.html#tag/Calendars/operation/Calendars_DeleteCalendar
     * Official documentation
     *
     * @param int|array $parameters Associative array containing request
     * parameters, or an array containing event ID's, or a single event ID
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
                    'CalendarIds' => $parameters,
                ];
            }
        } else {
            $parameters = [
                'CalendarIds' => [intval($parameters)],
            ];
        }

        $request = new Request('DELETE', 'v1/calendars/delete', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }

    /**
     * Add a contact to an event.
     *
     * @link https://api.whise.eu/WebsiteDesigner.html#tag/Calendars/operation/Calendars_UpdateCalendar
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
        $request = new Request('PATCH', 'v1/calendars/update', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }

    /**
     * Create a new appointment or insert new contacts into an existing one.
     *
     * @link https://api.whise.eu/WebsiteDesigner.html#tag/Calendars/operation/Calendars_UpsertCalendar
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
        $request = new Request('POST', 'v1/calendars/upsert', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }

    /**
     * Access endpoints related to calendar event types.
     *
     * @return CalendarsActions
     */
    public function actions(): CalendarsActions
    {
        if (is_null($this->actionsEndpoint)) {
            $this->actionsEndpoint = new CalendarsActions($this->api);
        }
        return $this->actionsEndpoint;
    }
}
