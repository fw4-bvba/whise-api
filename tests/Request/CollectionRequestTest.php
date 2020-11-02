<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Request;

use PHPUnit\Framework\TestCase;
use Whise\Api\Request\CollectionRequest;

class CollectionRequestTest extends TestCase
{
    public function testSetPage(): void
    {
        $request = new CollectionRequest('POST', '', []);
        $request->setPage(1);
        
        $body = json_decode($request->getBody(), true);
        
        $this->assertEquals([
            'Page' => [
                'Limit' => $request->getPageSize(),
                'Offset' => $request->getPageSize(),
            ],
        ], $body);
    }
}
