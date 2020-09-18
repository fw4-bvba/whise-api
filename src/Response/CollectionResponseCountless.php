<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

use Whise\Api\Request\Request;
use Whise\Api\Request\CollectionRequest;
use Whise\Api\ApiAdapter\ApiAdapterInterface;

class CollectionResponseCountless extends CollectionResponsePaginated
{
    public function __construct(CollectionRequest $request, ApiAdapterInterface $api_adapter)
    {
        $this->buffer = new CollectionResponseBufferCountless($request, $api_adapter);
    }
    
    /* ArrayAccess implementation */
    
    public function offsetExists($offset): bool
    {
        if (!is_int($offset)) {
            return false;
        }
        return $this->buffer->offsetExists($offset);
    }
}
