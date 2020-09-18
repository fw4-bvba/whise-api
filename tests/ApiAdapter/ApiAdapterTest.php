<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\ApiAdapter;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Request\Request;
use Whise\Api\Exception\InvalidRequestException;

class ApiAdapterTest extends ApiTestCase
{
    public function testInvalidRequest(): void
    {
        $request = new Request('GET', '');
        
        $this->expectException(InvalidRequestException::class);
        
        self::$adapter->queueResponse('{
            "isValidRequest": false
        }');
        $response = self::$adapter->request($request);
    }
    
    public function testInvalidRequestMessage(): void
    {
        $request = new Request('GET', '');
        
        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessage('test');
        
        self::$adapter->queueResponse('{
            "isValidRequest": false,
            "validationErrors": [
                {"message": "test"}
            ]
        }');
        $response = self::$adapter->request($request);
    }
    
    public function testDebugCallable(): void
    {
        $called = false;
        $request = new Request('GET', 'endpoint', 'body');
        
        self::$adapter->queueResponse('{}');
        self::$adapter->debugResponses(function($response_body, $endpoint, $request_body) use (&$called) {
            $called = true;
            
            $this->assertEquals('{}', $response_body);
            $this->assertEquals('endpoint', $endpoint);
            $this->assertEquals('body', $request_body);
        });
        
        $response = self::$adapter->request($request);
        
        $this->assertTrue($called);
    }
    
    public function testMissingResponseKey(): void
    {
        $request = new Request('GET', '');
        $request->setResponseKey('data');
        
        self::$adapter->queueResponse('{"isValidRequest": true}');
        
        $response = self::$adapter->request($request);
        
        $this->assertEquals([], $response->getData());
    }
}
