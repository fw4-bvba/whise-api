<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\ApiAdapter;

use Whise\Api\Request\Request;
use Whise\Api\Response\ResponseObject;
use Whise\Api\Response\ResponseData;
use Whise\Api\Exception;

abstract class ApiAdapter implements ApiAdapterInterface
{
    /** @var callable */
    protected $debugCallable;
    
    /**
     * Send a request to the API and return the parsed response.
     *
     * @param Request $request
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     *
     * @return ResponseData
     */
    public function request(Request $request): ResponseData
    {
        $response_body = $this->requestBody($request);
        
        // Send response to debug callback
        if (isset($this->debugCallable)) {
            ($this->debugCallable)($response_body, $request->getEndpoint(), $request->getBody());
        }
        
        $response = json_decode($response_body, false);
        
        // Check if request was valid
        if (isset($response->isValidRequest)) {
            if (!$response->isValidRequest) {
                if (!empty($response->validationErrors)) {
                    $message = implode(' ', array_filter(array_map(function ($error) {
                        return $error->message ?? '';
                    }, $response->validationErrors)));
                } else {
                    $message = 'Invalid request';
                }
                throw new Exception\InvalidRequestException($message);
            }
            unset($response->isValidRequest);
        }
        
        // Check if the data we need is contained in a property of the response
        if ($response_key = $request->getResponseKey()) {
            if (isset($response->$response_key)) {
                $data = $response->$response_key;
                unset($response->$response_key);
            } else {
                // The Whise API omits the property entirely if no data is available
                $data = [];
            }
            return new ResponseData($data, $response);
        } else {
            return new ResponseData($response);
        }
    }
    
    /**
     * Set a callback for debugging API requests and responses.
     *
     * @param callable|null $callable Callback that accepts up to three
     * arguments - respectively the response body, request endpoint, and the
     * request body.
     *
     * @return self
     */
    public function debugResponses(?callable $callable): void
    {
        $this->debugCallable = $callable;
    }
}
