<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Endpoints\AdminClients;

class AdminClientsTest extends ApiTestCase
{
    public function testList(): void
    {
        $endpoint = new AdminClients(self::$api);

        $this->queueResponse('{
            "clients": [1, 2, 3],
            "totalCount": 3
        }');
        $items = $endpoint->list();

        $this->assertCount(3, $items);
    }

    public function testSettings(): void
    {
        $endpoint = new AdminClients(self::$api);

        $this->queueResponse('{
            "settings": {"foo": "bar"}
        }');
        $response = $endpoint->settings(1);

        $this->assertEquals('bar', $response->foo);
    }

    public function testToken(): void
    {
        $endpoint = new AdminClients(self::$api);

        $this->queueResponse('{"foo": "bar"}');
        $response = $endpoint->token([]);

        $this->assertEquals('bar', $response->foo);
    }
}
