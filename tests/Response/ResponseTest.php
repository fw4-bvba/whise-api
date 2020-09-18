<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Response;

use PHPUnit\Framework\TestCase;
use Whise\Api\Exception\InvalidDataException;
use Whise\Api\Exception\InvalidPropertyException;
use Whise\Api\Response\Response;
use Whise\Api\Response\ResponseData;

class ResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $input = (object)[
            'foo' => 10
        ];
        $response_data = new ResponseData($input);
        $response = new Response($response_data);
        $data = $response->getData();
        
        $this->assertIsArray($data);
        $this->assertCount(1, $data);
        $this->assertArrayHasKey('foo', $data);
        $this->assertIsInt($data['foo']);
    }
}
