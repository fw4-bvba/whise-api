<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Response;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Request\CollectionRequest;
use Whise\Api\Response\CollectionResponsePaginated;
use Whise\Api\Response\CollectionResponseBuffer;

class CollectionResponsePaginatedTest extends ApiTestCase
{
    protected static $request;
    protected static $pageSize;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$request = new CollectionRequest('POST', '');
        self::$request->setResponseKey('data');
        self::$pageSize = self::$request->getPageSize();
    }

    public function testGet(): void
    {
        $this->queuePageResponse([1, 2, 3]);

        $response = new CollectionResponsePaginated(self::$request, self::$adapter);

        $this->assertEquals(3, $response->get(2));
    }

    public function testGetMultiple(): void
    {
        $this->queueFillerPages(self::$pageSize * 2);

        $response = new CollectionResponsePaginated(self::$request, self::$adapter);

        $this->assertEquals(1, $response->get(0));
        $this->assertEquals(1, $response->get(self::$pageSize));
    }

    public function testRequestBody(): void
    {
        $this->queueFillerPages(self::$pageSize * 2);

        $response = new CollectionResponsePaginated(self::$request, self::$adapter);

        self::$adapter->debugResponses(function ($response_body, $endpoint, $request_body) {
            $this->assertEquals('{"Page":{"Limit":50,"Offset":50}}', $request_body);
        });

        $response->get(self::$pageSize);
    }

    public function testMetadata(): void
    {
        $this->queueResponse([
            'data' => [1, 2, 3],
            'totalCount' => 3,
            'metadataProperty' => 'foo',
        ]);

        $response = new CollectionResponsePaginated(self::$request, self::$adapter);

        $this->assertEquals('foo', $response->metadata('metadataProperty'));
        $this->assertTrue($response->hasMetadata('metadataProperty'));
        $this->assertFalse($response->hasMetadata('invalid'));
        $this->assertIsArray($response->getMetadata());
    }

    protected function queuePageResponse($data, ?int $count = null): void
    {
        $this->queueResponse([
            'data' => $data,
            'totalCount' => $count ?? count($data),
        ]);
    }

    protected function queueFillerPages(int $total_count): void
    {
        $pages = ceil($total_count / self::$pageSize);
        for ($page = 0; $page < $pages; $page++) {
            $count = (($total_count - $page * self::$pageSize) % self::$pageSize) ?: self::$pageSize;
            $this->queuePageResponse(range(1, $count), $total_count);
        }
    }
}
