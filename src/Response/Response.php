<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Whise\Api\Response;

class Response extends ResponseObject
{
    public function __construct(ResponseData $response)
    {
        $this->_data = $response->getData();
    }
}
