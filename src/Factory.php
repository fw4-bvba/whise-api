<?php

namespace Whise\Api;

class Factory
{
    /**
     * Create a new instance of WhiseApi.
     *
     * @param mixed $accessToken
     * @param array|null $httpClientOptions
     *
     * @return WhiseApi
     */
    public function create(
        ?string $accessToken = null,
        ?array $httpClientOptions = null
    ): WhiseApi {
        return new WhiseApi($accessToken, $httpClientOptions);
    }
}
