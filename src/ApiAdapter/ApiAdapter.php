<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\ApiAdapter;

use Whise\Api\Request\Request;
use Whise\Api\Response\ResponseData;
use Whise\Api\Exception;
use Psr\Cache\CacheItemPoolInterface;

abstract class ApiAdapter
{
    /** @var callable */
    protected $debugCallable;

    /** @var CacheItemPoolInterface */
    protected $cache;

    /** @var int|DateTimeInterface|DateTimeInterval */
    protected $cacheTtl = 3600;

    /** @var string */
    protected $cachePrefix = 'whise-api';

    /**
     * Set the access token for authentication. You can retrieve one by using
     * the `token` endpoint, or by calling `requestAccessToken` on the API
     * client.
     *
     * @param string $token
     *
     * @return self
     */
    abstract public function setAccessToken(string $token): self;

    /**
     * Get the current access token for authentication.
     *
     * @throws Exception\AuthException if access token is missing or invalid
     *
     * @return string
     */
    abstract public function getAccessToken(): string;

    /**
     * Send a request to the API and return the raw response body.
     *
     * @param Request $request
     *
     * @return string
     */
    abstract public function requestBody(Request $request): string;

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
        $response_body = null;

        if ($this->cache && $request->getAllowsGreedyCache()) {
            $cache_key = $this->cachePrefix . '.' . sha1($this->getAccessToken() . $request->getCacheKey());
            $cache_item = $this->cache->getItem($cache_key);
            if ($cache_item->isHit()) {
                $response_body = $cache_item->get();
            }
        }

        if (is_null($response_body)) {
            $response_body = $this->requestBody($request);
        }

        // Send response to debug callback
        if (isset($this->debugCallable)) {
            ($this->debugCallable)($response_body, $request->getEndpoint(), $request->getBody());
        }

        $response = json_decode($response_body, false);

        // Check if request was valid
        if (isset($response->isValidRequest) || !empty($response->validationErrors)) {
            if (empty($response->isValidRequest)) {
                $messages = $codes = [];
                if (!empty($response->validationErrors)) {
                    foreach ($response->validationErrors as $error) {
                        if (!empty($error->message)) {
                            $messages[] = $error->message;
                        }
                        if (!empty($error->code)) {
                            $codes[] = $error->code;
                        }
                    }
                }
                throw new Exception\InvalidRequestException(
                    message: implode(' ', $messages) ?: 'Invalid request',
                    validationCodes: $codes,
                );
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
            $response_data = new ResponseData($data, $response);
        } else {
            $response_data = new ResponseData($response);
        }

        if ($this->cache && $request->getAllowsGreedyCache()) {
            $response_data->setCacheHit($cache_item->isHit());
            $response_data->setCacheKey($cache_key);
            if (!$cache_item->isHit()) {
                $cache_item->set($response_body);
                if ($this->cacheTtl === 0) {
                    $cache_item->expiresAfter(null);
                } elseif ($this->cacheTtl instanceof \DateTimeInterface) {
                    $cache_item->expiresAt($this->cacheTtl);
                } else {
                    $cache_item->expiresAfter($this->cacheTtl);
                }
                $this->cache->save($cache_item);
            }
        }

        return $response_data;
    }

    // Cache

    /**
     * Set a PSR-6 compatible adapter to use for caching.
     *
     * @param CacheItemPoolInterface|null $cache
     *
     * @return self
     */
    public function setCache(?CacheItemPoolInterface $cache): self
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * Get the current cache adapter.
     *
     * @return CacheItemPoolInterface|null
     */
    public function getCache(): ?CacheItemPoolInterface
    {
        return $this->cache;
    }

    /**
     * Change the cache lifetime.
     *
     * @param int|DateInterval|DateTimeInterface $ttl Time to cache in seconds,
     * or an explicit expiration date
     *
     * @return self
     */
    public function setCacheTtl($ttl): void
    {
        $this->cacheTtl = $ttl;
    }

    /**
     * Get the current cache lifetime.
     *
     * @return int|DateInterval|DateTimeInterface Time to cache in seconds, or
     * an explicit expiration date
     */
    public function getCacheTtl()
    {
        return $this->cacheTtl;
    }

    /**
     * Change the cache key prefix.
     *
     * @param string $prefix Prefix to use for cache keys
     *
     * @return self
     */
    public function setCachePrefix(string $prefix): void
    {
        $this->cachePrefix = $prefix;
    }

    /**
     * Get the cache key prefix.
     *
     * @return string Prefix to use for cache keys
     */
    public function getCachePrefix(): string
    {
        return $this->cachePrefix;
    }

    // Debugging

    /**
     * Set a callback for debugging API requests and responses.
     *
     * @param callable|null $callable Callback that accepts up to three
     * arguments - respectively the response body, request endpoint, and the
     * request body.
     *
     * @return self
     */
    public function debugResponses(?callable $callable): self
    {
        $this->debugCallable = $callable;
        return $this;
    }
}
