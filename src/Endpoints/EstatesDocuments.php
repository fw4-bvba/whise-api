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

final class EstatesDocuments extends Endpoint
{
    /**
     * Upload one or more documents for an estate.
     *
     * @link http://api.whise.eu/SystemIntegrator.html#operation/Estates_UploadDocuments
     * Official documentation
     *
     * @see Whise\Api\File for how to handle file data
     *
     * @param int $estate_id ID of the estate to attach the documents to
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
        
        $request = new Request('POST', 'v1/estates/documents/upload');
        $request->setResponseKey('documents')->requireAuthentication(true);
        
        $documents = $uploadable_files = [];
        foreach ($files as $file) {
            if (is_string($file) && is_readable($file)) {
                $file = new File($file);
            }
            if (!$file instanceof File) {
                throw new \InvalidArgumentException('EstatesDocuments::upload expects Whise\\Api\\File');
            }
            $uploadable_files[] = $file;
            $documents[] = $file->getMetadata();
        }
        
        $request->addMultipart('documents', json_encode([
            'EstateID' => $estate_id,
            'Documents' => $documents,
        ]));
        
        foreach ($uploadable_files as $index => $file) {
            $request->addMultipart(strval($index), $file->getFileResource());
        }
        
        return new CollectionResponse($this->getApiAdapter()->request($request));
    }
    
    /**
     * Delete one or more documents.
     *
     * @link http://api.whise.eu/SystemIntegrator.html#operation/Estates_DeleteDocuments
     * Official documentation
     *
     * @param int $estate_id ID of the estate from which to delete documents
     * @param int|array $document_ids Array of document ID's, or a single
     * document ID
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return Response
     */
    public function delete(int $estate_id, $document_ids): Response
    {
        if (!is_array($document_ids)) {
            $document_ids = [intval($document_ids)];
        }
        
        $parameters = [
            'EstateId' => $estate_id,
            'DocumentIdList' => $document_ids,
        ];
        
        $request = new Request('DELETE', 'v1/estates/documents/delete', $parameters);
        $request->requireAuthentication(true);
        return new Response($this->getApiAdapter()->request($request));
    }
}
