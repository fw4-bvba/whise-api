<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests;

use Whise\Api\ApiAdapter\ApiAdapter;
use Whise\Api\Request\Request;

final class TestApiAdapter extends ApiAdapter
{
    /** @var array */
    protected $responseQueue = [];

    public function clearQueue(): void
    {
        $this->responseQueue = [];
    }

    public function queueResponse(string $body): void
    {
        $this->responseQueue[] = $body;
    }

    /**
     * {@inheritdoc}
     */
     public function requestBody(Request $request): string
    {
		if (count($this->responseQueue) === 0) return null;

		$response = $this->responseQueue[0];
		array_shift($this->responseQueue);

        return $response;
    }

    public function setAccessToken(string $token): ApiAdapter
    {
        throw new \Exception('TestApiAdapter does not support access tokens');
    }

    public function getAccessToken(): string
    {
        return 'test';
    }
}
