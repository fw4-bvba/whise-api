<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Endpoints\EstatesOwned;

class EstatesOwnedTest extends ApiTestCase
{
    public function testList(): void
    {
        $endpoint = new EstatesOwned(self::$api);

        $this->queueResponse('{
            "estates": [1, 2, 3],
            "totalCount": 3
        }');

        self::$adapter->debugResponses(function ($response_body, $endpoint, $request_body) {
            $request = json_decode($request_body, true);
            unset($request['Page']);
            $this->assertEquals([
                'ContactUsername' => 'foo',
                'ContactPassword' => 'bar',
                'Filter' => [
                    'test' => 123,
                ],
            ], $request);
        });

        $items = $endpoint->list('foo', 'bar', [
            'test' => 123,
        ]);

        $this->assertCount(3, $items);
    }
}
