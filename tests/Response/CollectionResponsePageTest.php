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
use Whise\Api\Exception\PaginationException;

class CollectionResponsePageTest extends ApiTestCase
{
    public function testGetPage(): void
    {
        $page = $this->getResponse([1, 2, 3])->page(0, 20);

        $this->assertEquals($page->getPage(), 0);
    }

    public function testGetPageSize(): void
    {
        $page = $this->getResponse([1, 2, 3])->page(0, 20);

        $this->assertEquals($page->getPageSize(), 20);
    }

    public function testGetTotalCount(): void
    {
        $this->queueResponse([
            'data' => [1, 2, 3],
        ]);

        $request = new CollectionRequest('POST', '');
        $request->setResponseKey('data');
        $response = new CollectionResponsePaginated($request, self::$adapter);
        $page = $response->page(0, 20);

        $this->assertFalse($page->hasTotalCount());
        $this->assertNull($page->getTotalCount());
    }

    public function testGetTotalCountInvalid(): void
    {
        $page = $this->getResponse([1, 2, 3])->page(0, 20);

        $this->assertEquals($page->getTotalCount(), 3);
    }

    public function testGetPageCount(): void
    {
        $page = $this->getResponse([1, 2, 3], 12)->page(0, 3);

        $this->assertEquals($page->getPageCount(), 4);
    }

    protected function getResponse($data, ?int $count = null): CollectionResponsePaginated
    {
        $this->queueResponse([
            'data' => $data,
            'totalCount' => $count ?? count($data),
        ]);

        $request = new CollectionRequest('POST', '');
        $request->setResponseKey('data');
        return new CollectionResponsePaginated($request, self::$adapter);
    }
}
