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
use Whise\Api\Response\CollectionResponseCountless;
use Whise\Api\Response\CollectionResponseBufferCountless;

class CollectionResponseCountlessTest extends ApiTestCase
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

    public function testOffsetExists(): void
    {
        $this->queueFillerPages(self::$pageSize * 2);

        $response = new CollectionResponseCountless(self::$request, self::$adapter);

        $this->assertTrue($response->offsetExists(0));
        $this->assertTrue($response->offsetExists(self::$pageSize * 2 - 1));
        $this->assertFalse($response->offsetExists(self::$pageSize * 2));
    }

    public function testOffsetExistsInvalid(): void
    {
        $this->queueFillerPages(1);

        $buffer = new CollectionResponseCountless(self::$request, self::$adapter);

        $this->assertFalse($buffer->offsetExists('invalid'));
    }

    public function testUpperBound(): void
    {
        $this->queuePageResponse(range(1, self::$pageSize));
        $response = new CollectionResponseCountless(self::$request, self::$adapter);

        $this->assertTrue($response->offsetExists(0));

        $this->queuePageResponse([]);
        $this->assertFalse($response->offsetExists(self::$pageSize * 3));

        $this->queuePageResponse([]);
        $this->assertFalse($response->offsetExists(self::$pageSize * 2));

        $this->queuePageResponse(range(1, self::$pageSize));
        $this->assertTrue($response->offsetExists(self::$pageSize));
    }

    protected function queuePageResponse($data): void
    {
        $this->queueResponse([
            'data' => $data,
        ]);
    }

    protected function queueFillerPages(int $total_count): void
    {
        $pages = ceil($total_count / self::$pageSize);
        for ($page = 0; $page < $pages; $page++) {
            $count = (($total_count - $page * self::$pageSize) % self::$pageSize) ?: self::$pageSize;
            $this->queuePageResponse(range(1, $count));
        }
        $this->queuePageResponse([]);
    }
}
