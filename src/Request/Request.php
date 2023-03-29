<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Request;

use DateTime;
use JsonSerializable;

class Request implements JsonSerializable
{
    /** @var string */
    protected $method;

    /** @var string */
    protected $endpoint;

    /** @var array */
    protected $parameters;

    /** @var array */
    protected $headers;

    /** @var array|string|null */
    protected $body;

    /** @var string|null */
    protected $responseKey;

    /** @var bool */
    protected $requiresAuthentication = false;

    /** @var bool */
    protected $allowsGreedyCache = false;

    /** @var array|null */
    protected $multiparts;

    public function __construct(
        string $method,
        string $endpoint,
        $body = null,
        array $parameters = [],
        array $headers = []
    ) {
        $this->setMethod($method);
        $this->setEndpoint($endpoint);
        $this->setParameters($parameters);
        $this->setHeaders($headers);
        if (isset($body)) {
            $this->setBody($body);
        }
    }

    /**
     * Determine whether or not the request requires an access token.
     *
     * @param bool $requires_authentication
     *
     * @return self
     */
    public function requireAuthentication(bool $requires_authentication = true): Request
    {
        $this->requiresAuthentication = $requires_authentication;
        return $this;
    }

    /**
     * Check whether or not the request requires an access token.
     *
     * @return bool
     */
    public function getRequiresAuthentication(): bool
    {
        return $this->requiresAuthentication;
    }

    /**
     * Determine whether the response should be allowed to be cached.
     *
     * @param bool $allow_cache
     *
     * @return self
     */
    public function allowGreedyCache(bool $allow_cache = true): Request
    {
        $this->allowsGreedyCache = $allow_cache;
        return $this;
    }

    /**
     * Determine whether the response should be allowed to be cached.
     *
     * @param bool $allow_cache
     *
     * @return self
     */
    public function getAllowsGreedyCache(): bool
    {
        return $this->allowsGreedyCache;
    }

    /**
     * Set the HTTP method to use for this request.
     *
     * @param string $method HTTP method like GET, POST, PATCH or DELETE
     *
     * @return self
     */
    public function setMethod(string $method): Request
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Get the HTTP method to use for this request.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set the endpoint/URI path to query.
     *
     * @param string $endpoint
     *
     * @return self
     */
    public function setEndpoint(string $endpoint): Request
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * Get the endpoint/URI path to query.
     *
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Set the HTTP query string parameters.
     *
     * @param array $parameters Associative array of parameter names and values
     *
     * @return self
     */
    public function setParameters(array $parameters): Request
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * Get the HTTP query string parameters.
     *
     * @return array Unencoded associative array of parameter names and values
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Set additional HTTP headers.
     *
     * @param array $parameters Associative array of header names and values
     *
     * @return self
     */
    public function setHeaders(array $headers): Request
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Get additional HTTP headers.
     *
     * @return array Associative array of header names and values
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set the HTTP body to send.
     *
     * @param array|string $body Raw string or associative array to send as JSON
     *
     * @return self
     */
    public function setBody($body): Request
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Get the HTTP body to send.
     *
     * @return string|null
     */
    public function getBody(): ?string
    {
        if (is_null($this->body) || is_string($this->body)) {
            return $this->body;
        } else {
            return json_encode($this->encode($this->body));
        }
    }

    /**
     * Set the name of the property which we're expecting the actual response
     * data to be contained within.
     *
     * @param string|null $key
     *
     * @return self
     */
    public function setResponseKey(?string $key): Request
    {
        $this->responseKey = $key;
        return $this;
    }

    /**
     * Get the name of the property which we're expecting the actual response
     * data to be contained within.
     *
     * @return string|null
     */
    public function getResponseKey(): ?string
    {
        return $this->responseKey;
    }

    /**
     * Add a file or form data to the request. If a body is already set,
     * multipart data is ignored.
     *
     * @param string $name Form data field name, or name for file data
     * @param mixed $contents Form data field value, or raw file contents
     * @param string|null $filename Filename string or null if form data
     * @param array|null $headers Additional HTTP headers relevant to this part
     *
     * @return self
     */
    public function addMultipart(string $name, $contents, ?string $filename = null, ?array $headers = null): Request
    {
        if (!isset($this->multiparts)) {
            $this->multiparts = [];
        }
        $multipart = [
            'name' => $name,
            'contents' => $contents,
        ];
        if (isset($filename)) {
            $multipart['filename'] = $filename;
        }
        if (isset($headers)) {
            $multipart['headers'] = $headers;
        }
        $this->multiparts[] = $multipart;

        return $this;
    }

    /**
     * Get files and form data to be sent.
     *
     * @return array
     */
    public function getMultiparts(): ?array
    {
        return $this->multiparts;
    }

    /**
     * Recursively encode a value into a format understood by the Whise API.
     *
     * @param mixed $encodable
     *
     * @return self
     */
    protected function encode($encodable)
    {
        if (is_array($encodable)) {
            foreach ($encodable as $key => $value) {
                $encodable[$key] = $this->encode($value);
            }
        } elseif ($encodable instanceof DateTime) {
            return $encodable->format('c');
        }
        return $encodable;
    }

    public function getCacheKey(): string
    {
        return $this->endpoint . json_encode($this->getParameters()) . $this->getBody();
    }

    /* JsonSerializable implementation */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->getBody();
    }
}
