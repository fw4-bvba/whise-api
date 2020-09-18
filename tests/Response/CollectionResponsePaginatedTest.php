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
    static protected $request;
    static protected $pageSize;
    
    static public function setUpBeforeClass(): void
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
    
    public function testGetPageSize(): void
    {
        $this->queuePageResponse([1, 2, 3]);
        
        $response = new CollectionResponsePaginated(self::$request, self::$adapter);
        
        $this->assertEquals($response->getPageSize(), self::$pageSize);
    }
    
    public function testGetPageCount(): void
    {
        $this->queueFillerPages(self::$pageSize * 2);
        
        $response = new CollectionResponsePaginated(self::$request, self::$adapter);
        
        $this->assertEquals(2, $response->getPageCount());
    }
    
    public function testBufferGetBuffer(): void
    {
        $this->queueFillerPages(self::$pageSize * 2);
        
        $buffer = new CollectionResponseBuffer(self::$request, self::$adapter);
        
        $this->assertCount(self::$pageSize, $buffer->getBuffer());
    }
    
    public function testBufferGet(): void
    {
        $this->queueFillerPages(self::$pageSize * 2);
        
        $buffer = new CollectionResponseBuffer(self::$request, self::$adapter);
        
        $this->assertEquals(1, $buffer->get(0));
        $this->assertEquals(1, $buffer->get(self::$pageSize));
    }
    
    public function testBufferOffsetExists(): void
    {
        $this->queuePageResponse([1, 2, 3]);
        
        $buffer = new CollectionResponseBuffer(self::$request, self::$adapter);
        
        $this->assertTrue($buffer->offsetExists(2));
        $this->assertFalse($buffer->offsetExists(3));
    }
    
    public function testBufferGetPage(): void
    {
        $this->queueFillerPages(self::$pageSize * 2);
        
        $buffer = new CollectionResponseBuffer(self::$request, self::$adapter);
        
        $buffer->bufferPage(0);
        $this->assertEquals(0, $buffer->getBufferedPage());
        
        $buffer->bufferPage(1);
        $this->assertEquals(1, $buffer->getBufferedPage());
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
