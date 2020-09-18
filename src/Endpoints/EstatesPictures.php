<?php

/*
* This file is part of the fw4/whise-api library
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Whise\Api\Endpoints;

use Whise\Api\Endpoint;
use Whise\Api\File;
use Whise\Api\Request\Request;
use Whise\Api\Response\Response;
use Whise\Api\Response\CollectionResponse;

final class EstatesPictures extends Endpoint
{
    /**
     * Upload one or more photos for an estate.
     *
     * @link http://api.whise.eu/SystemIntegrator.html#operation/Estates_UploadPictures
     * Official documentation
     *
     * @see Whise\Api\File for how to handle file data
     *
     * @param int $estate_id ID of the estate to attach the photos to
     * @param array|File $files Array of files, or a single file
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return Response
     */
    public function upload(int $estate_id, $files): CollectionResponse
    {
        if (!is_array($files)) {
            $files = array_slice(func_get_args(), 1);
        }
        
        $request = new Request('POST', 'v1/estates/pictures/upload');
        $request->setResponseKey('pictures')->requireAuthentication(true);
        
        $pictures = $uploadable_files = [];
        foreach ($files as $file) {
            if (is_string($file) && is_readable($file)) {
                $file = new File($file);
            }
            if (!$file instanceof File) {
                throw new \InvalidArgumentException('EstatesPictures::upload expects Whise\\Api\\File');
            }
            $uploadable_files[] = $file;
            $pictures[] = $file->getMetadata();
        }
        
        $request->addMultipart('pictures', json_encode([
            'EstateID' => $estate_id,
            'Pictures' => $pictures,
        ]));
        
        foreach ($uploadable_files as $index => $file) {
            $request->addMultipart(strval($index), $file->getFileResource());
        }
        
        return new CollectionResponse($this->getApiAdapter()->request($request));
    }
    
    /**
     * Delete one or more photos.
     *
     * @link http://api.whise.eu/SystemIntegrator.html#operation/Estates_DeletePictures
     * Official documentation
     *
     * @param int $estate_id ID of the estate from which to delete photos
     * @param int|array $photo_ids Array of photo ID's, or a single photo ID
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return Response
     */
    public function delete(int $estate_id, $photo_ids): Response
    {
        if (!is_array($photo_ids)) {
            $photo_ids = [intval($photo_ids)];
        }
        
        $parameters = [
            'EstateId' => $estate_id,
            'PictureIdList' => $photo_ids,
        ];
        
        $request = new Request('DELETE', 'v1/estates/pictures/delete', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }
}
