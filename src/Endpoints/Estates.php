<?php

/*
* This file is part of the fw4/whise-api library
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Whise\Api\Endpoints;

use Whise\Api\Endpoint;
use Whise\Api\Enums;
use Whise\Api\Request\Request;
use Whise\Api\Request\CollectionRequest;
use Whise\Api\Response\Response;
use Whise\Api\Response\CollectionResponse;
use Whise\Api\Response\CollectionResponsePaginated;

class Estates extends Endpoint
{
    /** @var EstatesRegions */
    protected $regionsEndpoint;

    /** @var EstatesUsedCities */
    protected $usedCitiesEndpoint;

    /** @var EstatesUsedCountries */
    protected $usedCountriesEndpoint;

    /** @var EstatesPictures */
    protected $picturesEndpoint;

    /** @var EstatesDocuments */
    protected $documentsEndpoint;

    /** @var EstatesExports */
    protected $exportsEndpoint;

    /** @var EstatesOwned */
    protected $ownedEndpoint;

    /** @var EstatesDetails */
    protected $detailsEndpoint;

    /**
     * Request a list of real estate properties and/or projects.
     *
     * @link https://api.whise.eu/WebsiteDesigner.html#tag/Estates/operation/Estates_GetEstates
     * Official documentation
     *
     * @param array $filter Associative array containing filter parameters
     * @param array $sort Array containing associative arrays with sorting
     * parameters
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
        // Check if $sort is associative, and enclose it in an array if it is
        if (is_array($sort) && count(array_intersect(array_map('strtolower', array_keys($sort)), ['field', 'ascending']))) {
            $sort = [$sort];
        }

        $parameters = $this->getFilterParameters([
            'Filter' => $filter,
            'Sort' => $sort,
            'Field' => $field,
        ]);

        $request = new CollectionRequest('POST', 'v1/estates/list', $parameters);
        $request->setResponseKey('estates')->requireAuthentication(true)->allowGreedyCache(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }

    /**
     * Request a single real estate property and/or project.
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
        $estates = $this->list(array_merge([
            'EstateIds' => [$id],
            'StatusIds' => Enums\Status::all(),
            'DisplayStatusIds' => Enums\DisplayStatus::all(),
            'IncludeGroupEstates' => true,
        ], $filter), null, $field)->page(0, 1);

        if (isset($estates[0])) {
            $response = new Response($estates[0]);
            $response->transferCacheAttributes($estates);
            return $response;
        } else {
            return null;
        }
    }

    /**
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
        $request = new Request('PATCH', 'v1/estates/update', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
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
        $request = new Request('POST', 'v1/estates/create', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }


    /**
     * @internal
     *
     * @param int|array $parameters Associative array containing request
     * parameters, or a single estate ID
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
        if (!is_array($parameters)) {
            $parameters = [
                'EstateId' => intval($parameters),
            ];
        }
        $request = new Request('DELETE', 'v1/estates/delete', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }

    /**
     * Access endpoints related to regions.
     *
     * @return EstatesRegions
     */
    public function regions(): EstatesRegions
    {
        if (is_null($this->regionsEndpoint)) {
            $this->regionsEndpoint = new EstatesRegions($this->api);
        }
        return $this->regionsEndpoint;
    }

    /**
     * Access endpoints related to cities in use.
     *
     * @return EstatesUsedCities
     */
    public function usedCities(): EstatesUsedCities
    {
        if (is_null($this->usedCitiesEndpoint)) {
            $this->usedCitiesEndpoint = new EstatesUsedCities($this->api);
        }
        return $this->usedCitiesEndpoint;
    }

    /**
     * Access endpoints related to countries in use.
     *
     * @return EstatesUsedCountries
     */
    public function usedCountries(): EstatesUsedCountries
    {
        if (is_null($this->usedCountriesEndpoint)) {
            $this->usedCountriesEndpoint = new EstatesUsedCountries($this->api);
        }
        return $this->usedCountriesEndpoint;
    }

    /**
     * Access endpoints related to estate pictures.
     *
     * @return EstatesPictures
     */
    public function pictures(): EstatesPictures
    {
        if (is_null($this->picturesEndpoint)) {
            $this->picturesEndpoint = new EstatesPictures($this->api);
        }
        return $this->picturesEndpoint;
    }

    /**
     * Access endpoints related to estate documents.
     *
     * @return EstatesDocuments
     */
    public function documents(): EstatesDocuments
    {
        if (is_null($this->documentsEndpoint)) {
            $this->documentsEndpoint = new EstatesDocuments($this->api);
        }
        return $this->documentsEndpoint;
    }

    /**
     * Access endpoints related to media exports.
     *
     * @return EstatesExports
     */
    public function exports(): EstatesExports
    {
        if (is_null($this->exportsEndpoint)) {
            $this->exportsEndpoint = new EstatesExports($this->api);
        }
        return $this->exportsEndpoint;
    }

    /**
     * Access endpoints related to estate ownership.
     *
     * @return EstatesOwned
     */
    public function owned(): EstatesOwned
    {
        if (is_null($this->ownedEndpoint)) {
            $this->ownedEndpoint = new EstatesOwned($this->api);
        }
        return $this->ownedEndpoint;
    }

    /**
     * Access endpoints related to available estate sub-details.
     *
     * @return EstatesDetails
     */
    public function details(): EstatesDetails
    {
        if (is_null($this->detailsEndpoint)) {
            $this->detailsEndpoint = new EstatesDetails($this->api);
        }
        return $this->detailsEndpoint;
    }
}
