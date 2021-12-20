<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Endpoints\AdminOffices;

class AdminOfficesTest extends ApiTestCase
{
    public function testList(): void
    {
        $endpoint = new AdminOffices(self::$api);

        $this->queueResponse('{
            "offices": [1, 2, 3],
            "totalCount": 3
        }');
        $items = $endpoint->list();

        $this->assertCount(3, $items);
    }

    public function testConsistentTotalCount(): void
    {
        $endpoint = new AdminOffices(self::$api);

        $this->queueResponse([
            'offices' => array_fill(0, 3, 1),
            'totalCount' => 100
        ]);
        $items = $endpoint->list();

        $this->assertCount(100, $items);
    }

    public function testInconsistentTotalCount(): void
    {
        $endpoint = new AdminOffices(self::$api);

        $this->queueResponse([
            'offices' => array_fill(0, 3, 1),
            'totalCount' => 100
        ]);
        $page = $endpoint->list([
            'OfficeIds' => [1, 2, 3],
        ]);

        $this->assertCount(3, $page);
    }
}
