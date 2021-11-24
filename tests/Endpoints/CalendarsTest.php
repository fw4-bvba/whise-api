<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Endpoints\Calendars;
use Whise\Api\Endpoints\CalendarsActions;

class CalendarsTest extends ApiTestCase
{
    public function testList(): void
    {
        $endpoint = new Calendars(self::$api);

        $this->queueResponse('{
            "calendars": [1, 2, 3],
            "totalCount": 3
        }');
        $items = $endpoint->list();

        $this->assertCount(3, $items);
    }

    public function testCreate(): void
    {
        $endpoint = new Calendars(self::$api);

        $this->queueResponse('{"foo": "bar"}');
        $response = $endpoint->create([]);

        $this->assertEquals('bar', $response->foo);
    }

    public function testDelete(): void
    {
        $endpoint = new Calendars(self::$api);

        $this->queueResponse('{"foo": "bar"}');
        $response = $endpoint->delete(1);

        $this->assertEquals('bar', $response->foo);
    }

    public function testDeleteMultiple(): void
    {
        $endpoint = new Calendars(self::$api);

        $this->queueResponse('{"foo": "bar"}');
        $response = $endpoint->delete([1, 2]);

        $this->assertEquals('bar', $response->foo);
    }

    public function testUpdate(): void
    {
        $endpoint = new Calendars(self::$api);

        $this->queueResponse('{"foo": "bar"}');
        $response = $endpoint->update([]);

        $this->assertEquals('bar', $response->foo);
    }

    public function testUpsert(): void
    {
        $endpoint = new Calendars(self::$api);

        $this->queueResponse('{"foo": "bar"}');
        $response = $endpoint->upsert([]);

        $this->assertEquals('bar', $response->foo);
    }

    public function testActions(): void
    {
        $endpoint = new Calendars(self::$api);
        $this->assertTrue($endpoint->actions() instanceof CalendarsActions);
    }
}
