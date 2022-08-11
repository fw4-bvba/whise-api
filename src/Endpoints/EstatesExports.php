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

final class EstatesExports extends Endpoint
{
    /**
     * Request a list of estates to be exported.
     *
     * @link http://api.whise.eu/WebsiteMedia.html#operation/Estates_GetEstatesToBeExportedToMedia
     * Official documentation
     *
     * @param int $office_id ID of the office of which to retrieve estates
     * @param bool $show_representatives Whether to include representative (real
     * estate agent) data
     * @param bool $reset Pass true to retrieve all estates, regardless of
     * export status (rate-limited to once per office per day)
     * @param array $language_ids For the fields that contain data translated in
     * multiple languages, only the value(s) corresponding to the given
     * language(s) will be returned. If no language is selected, client's
     * default language / English will be taken by default.
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return CollectionResponse Traversable collection of items
     */
    public function list(int $office_id, ?bool $show_representatives = null, ?bool $reset = null, ?array $language_ids = null): CollectionResponse
    {
        $parameters = [
            'OfficeId' => $office_id,
        ];

        if (!is_null($show_representatives)) {
            $parameters['ShowRepresentatives'] = $show_representatives;
        }

        if (!is_null($reset)) {
            $parameters['IsReset'] = $reset;
        }

        if (!is_null($language_ids)) {
            $parameters['LanguageIds'] = $language_ids;
        }

        $request = new CollectionRequest('POST', 'v1/estates/exports/list', $parameters);
        $request->setResponseKey('estates')->requireAuthentication(true)->allowGreedyCache(true);
        return new CollectionResponsePaginated($request, $this->getApiAdapter());
    }

    /**
     * Confirm the publication of an estate. Call this endpoint whenever an
     * estate is published, or when an error occurs.
     *
     * @link http://api.whise.eu/WebsiteMedia.html#operation/Estates_UpdateEstateExportStatus
     * Official documentation
     *
     * @param int $estate_id
     * @param int $export_status The new publication status of the estate. Check
     * Whise\Api\Enums\ExportStatus for available values.
     * @param int|string $id_in_media The ID or reference that has been assigned
     * to this estate by your application.
     * @param string $export_message Additional information or error message
     * relevant to the publication status of the estate.
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     */
    public function changeStatus(int $estate_id, int $export_status, $id_in_media = null, ?string $export_message = null): void
    {
        $parameters = [
            'EstateId'     => $estate_id,
            'ExportStatus' => $export_status,
        ];

        if (!is_null($id_in_media)) {
            $parameters['IdInMedia'] = strval($id_in_media);
        }

        if (!is_null($export_message)) {
            $parameters['ExportMessage'] = $export_message;
        }

        $request = new Request('POST', 'v1/estates/exports/changestatus', $parameters);
        $request->requireAuthentication(true);
        $this->getApiAdapter()->request($request);
    }
}
