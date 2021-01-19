<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\ApiAdapter;

use Whise\Api\Request\Request;
use Whise\Api\Exception\AuthException;
use Whise\Api\Exception\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use PackageVersions\Versions;

/**
 * @codeCoverageIgnore
 */
final class HttpApiAdapter extends ApiAdapter
{
    private const BASE_URI = 'https://api.whise.eu/';

    /** @var string */
    private $accessToken;

    /** @var Client */
    private $client;

    public function __construct(array $http_client_options = [])
    {
        $http_client_options['base_uri'] = self::BASE_URI;
        if (!isset($http_client_options['headers']) || !is_array($http_client_options['headers'])) {
            $http_client_options['headers'] = [];
        }
        if (empty($http_client_options['headers']['User-Agent'])) {
            $version = Versions::getVersion('fw4/whise-api');
            $http_client_options['headers']['User-Agent'] = 'fw4-whise-api/' . $version;
        }
        $http_client_options['headers']['Accept'] = 'application/json';
        $http_client_options['headers']['Content-Type'] = 'application/json';

        $this->client = new Client(array_merge([
            'timeout' => 10.0,
            'http_errors' => false,
        ], $http_client_options));
    }

    /**
     * {@inheritdoc}
     */
    public function setAccessToken(string $token): ApiAdapter
    {
        $this->accessToken = $token;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessToken(): string
    {
        if (empty($this->accessToken)) {
            throw new AuthException('Missing access token. Call setAccessToken to use an existing token, or call requestAccessToken with your client credentials to retrieve a new one.');
        }
        return $this->accessToken;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception\InvalidRequestException if the API rejects the request
     * due to invalid input
     * @throws Exception\AuthException if access is denied
     * @throws Exception\AuthException if access token is missing or invalid
     * @throws Exception\ApiException if a server-side error occurred
     */
    public function requestBody(Request $request): string
    {
        $parameters = $request->getParameters();
        $headers = $request->getHeaders();
        $body = $request->getBody();
        $multiparts = $request->getMultiparts();

        // Set access token if request requires authentication
        if ($request->getRequiresAuthentication()) {
            $headers['Authorization'] = 'Bearer ' . $this->getAccessToken();
        }

        $options = [];
        if (count($parameters)) {
            $options['query'] = $parameters;
        }
        if (count($headers)) {
            $options['headers'] = $headers;
        }
        if ($body) {
            $options['body'] = $body;
        } elseif (isset($multiparts)) {
            $options['multipart'] = $multiparts;
        } else {
            $options['body'] = '{}';
        }

        $guzzle_request = new GuzzleRequest($request->getMethod(), $request->getEndpoint(), $headers);
        $response = $this->client->send($guzzle_request, $options);
        $body = $response->getBody()->getContents();
        if ($response->getStatusCode() === 401) {
            // Parse authorization errors
            throw new AuthException($response->getReasonPhrase(), 401);
        } elseif ($response->getStatusCode() >= 400) {
            // Parse other errors
            $response_data = json_decode($body, false);
            if (!empty($response_data->ExceptionMessage)) {
                $message = $response_data->ExceptionMessage;
            } elseif (!empty($response_data->Message)) {
                $message = $response_data->Message;
            } else {
                $message = $response->getReasonPhrase();
            }
            if (!empty($response_data->MessageDetail)) {
                $message .= ' ' . $response_data->MessageDetail;
            }
            throw new ApiException($message);
        }
        return $body;
    }

    public function getHttpClient(): Client
    {
        return $this->client;
    }
}
