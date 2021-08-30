<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\ApiAdapter;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Tests\TestApiAdapter;
use Whise\Api\Request\Request;
use Whise\Api\Exception\InvalidRequestException;
use Cache\Adapter\PHPArray\ArrayCachePool;

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
        self::$adapter->debugResponses(function ($response_body, $endpoint, $request_body) use (&$called) {
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

    public function testCache(): void
    {
        $cache = new ArrayCachePool();

        $adapter = new TestApiAdapter();
        $adapter->setCache($cache);
        $adapter->setCacheTtl(0);

        $adapter->queueResponse('{
            "foo": 1
        }');
        $request = new Request('POST', 'endpoint');
        $request->allowGreedyCache(true);
        $response = $adapter->request($request);

        $adapter->queueResponse('{
            "foo": 2
        }');
        $request = new Request('POST', 'endpoint');
        $request->allowGreedyCache(true);
        $response = $adapter->request($request);

        $this->assertEquals(1, $response->foo);
    }

    public function testCacheDifferentKeys(): void
    {
        $cache = new ArrayCachePool();

        $adapter = new TestApiAdapter();
        $adapter->setCache($cache);

        $adapter->queueResponse('{}');
        $request_a = new Request('POST', 'endpoint', [
            'foo' => 1,
        ]);
        $request_a->allowGreedyCache(true);
        $response_a = $adapter->request($request_a);

        $adapter->queueResponse('{}');
        $request_b = new Request('POST', 'endpoint', [
            'foo' => 2,
        ]);
        $request_b->allowGreedyCache(true);
        $response_b = $adapter->request($request_b);

        $this->assertNotNull($response_a->getCacheKey());
        $this->assertNotNull($response_b->getCacheKey());
        $this->assertNotEquals($response_a->getCacheKey(), $response_b->getCacheKey());
    }

    public function testCacheTtlPermanent(): void
    {
        $cache = new ArrayCachePool();

        $adapter = new TestApiAdapter();
        $adapter->setCache($cache);

        $adapter->setCacheTtl(0);
        $adapter->queueResponse('{}');
        $request = new Request('POST', 'endpoint');
        $request->allowGreedyCache(true);
        $response = $adapter->request($request);

        $cache_item = $cache->getItem($response->getCacheKey());

        $this->assertTrue($cache_item->isHit());
        $this->assertNull($cache_item->getExpirationTimestamp());
    }

    public function testCacheTtlDateTime(): void
    {
        $cache = new ArrayCachePool();
        $date = new \DateTime('+1 year');

        $adapter = new TestApiAdapter();
        $adapter->setCache($cache);

        $adapter->setCacheTtl($date);
        $adapter->queueResponse('{"a":1}');
        $request = new Request('POST', 'endpoint');
        $request->allowGreedyCache(true);
        $response = $adapter->request($request);

        $cache_item = $adapter->getCache()->getItem($response->getCacheKey());

        $this->assertTrue($cache_item->isHit());
        $this->assertEquals($date->getTimestamp(), $cache_item->getExpirationTimestamp());
    }

    public function testCacheTtlDateInterval(): void
    {
        $cache = new ArrayCachePool();
        $interval = new \DateInterval('P1Y');

        $date = new \DateTime();
        $date->add($interval);

        $adapter = new TestApiAdapter();
        $adapter->setCache($cache);

        $adapter->setCacheTtl($interval);
        $adapter->queueResponse('{"a":1}');
        $request = new Request('POST', 'endpoint');
        $request->allowGreedyCache(true);
        $response = $adapter->request($request);

        $cache_item = $adapter->getCache()->getItem($response->getCacheKey());

        $this->assertTrue($cache_item->isHit());
        $this->assertEqualsWithDelta($date->getTimestamp(), $cache_item->getExpirationTimestamp(), 2);
    }
}
