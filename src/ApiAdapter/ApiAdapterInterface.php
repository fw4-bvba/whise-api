<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\ApiAdapter;

use Whise\Api\Request\Request;

interface ApiAdapterInterface
{
    /**
     * Set the access token for authentication. You can retrieve one by using
     * the `token` endpoint, or by calling `requestAccessToken` on the API
     * client.
     *
     * @param string $token
     *
     * @return self
     */
    public function setAccessToken(string $token): ApiAdapterInterface;
    
    /**
     * Send a request to the API and return the raw response body.
     *
     * @param Request $request
     *
     * @return string
     */
    public function requestBody(Request $request): string;
}
