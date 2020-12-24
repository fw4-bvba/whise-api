<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Endpoints\Estates;
use Whise\Api\Endpoints\EstatesRegions;
use Whise\Api\Endpoints\EstatesUsedCities;
use Whise\Api\Endpoints\EstatesPictures;
use Whise\Api\Endpoints\EstatesDocuments;

class EstatesTest extends ApiTestCase
{
    public function testList(): void
    {
        $endpoint = new Estates(self::$api);

        $this->queueResponse('{
            "estates": [1, 2, 3],
            "totalCount": 3
        }');
        $items = $endpoint->list();

        $this->assertCount(3, $items);
    }

    public function testGet(): void
    {
        $endpoint = new Estates(self::$api);

        $this->queueResponse('{
            "estates": [{
                "id": 1
            }],
            "totalCount": 1
        }');
        $item = $endpoint->get(1);

        $this->assertEquals(1, $item->id);
    }

    public function testGetNull(): void
    {
        $endpoint = new Estates(self::$api);

        $this->queueResponse('{
            "estates": [],
            "totalCount": 0
        }');
        $item = $endpoint->get(1);

        $this->assertNull($item);
    }

    public function testUpdate(): void
    {
        $endpoint = new Estates(self::$api);

        $this->queueResponse('{"foo": "bar"}');
        $response = $endpoint->update([]);

        $this->assertEquals('bar', $response->foo);
    }

    public function testCreate(): void
    {
        $endpoint = new Estates(self::$api);

        $this->queueResponse('{"foo": "bar"}');
        $response = $endpoint->create([]);

        $this->assertEquals('bar', $response->foo);
    }

    public function testDelete(): void
    {
        $endpoint = new Estates(self::$api);

        $this->queueResponse('{"foo": "bar"}');
        $response = $endpoint->delete(1);

        $this->assertEquals('bar', $response->foo);
    }

    public function testRegions(): void
    {
        $endpoint = new Estates(self::$api);
        $this->assertTrue($endpoint->regions() instanceof EstatesRegions);
    }

    public function testUsedCities(): void
    {
        $endpoint = new Estates(self::$api);
        $this->assertTrue($endpoint->usedCities() instanceof EstatesUsedCities);
    }

    public function testPictures(): void
    {
        $endpoint = new Estates(self::$api);
        $this->assertTrue($endpoint->pictures() instanceof EstatesPictures);
    }

    public function testDocuments(): void
    {
        $endpoint = new Estates(self::$api);
        $this->assertTrue($endpoint->documents() instanceof EstatesDocuments);
    }
}
