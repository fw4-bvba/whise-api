<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

class Response extends ResponseObject implements CacheInterface
{
    use CacheTrait;

    public function __construct(ResponseObject $response)
    {
        $this->_data = $response->getData();
        if ($response instanceof CacheInterface) {
            $this->transferCacheAttributes($response);
        }
    }
}
