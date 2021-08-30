<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests;

use PHPUnit\Framework\TestCase;
use Whise\Api\Endpoints\Calendars;

class EndpointTest extends ApiTestCase
{
    public function testFilterParameters(): void
    {
        self::$api->debugResponses(function ($response, $endpoint, $request) {
            $request = json_decode($request, true);
            $this->assertEquals('bar', $request['Filter']['foo'] ?? null);
        });

        $this->queueResponse('{
            "calendars": [],
            "totalCount": 0
        }');
        $endpoint = new Calendars(self::$api);
        $endpoint->list([
            'foo' => 'bar'
        ])->offsetExists(0);
    }

    public function testRawFilterParameters(): void
    {
        self::$api->debugResponses(function ($response, $endpoint, $request) {
            $request = json_decode($request, true);
            $this->assertEquals('bar', $request['Filter']['foo'] ?? null);
        });

        $this->queueResponse('{
            "calendars": [],
            "totalCount": 0
        }');
        $endpoint = new Calendars(self::$api);
        $endpoint->list([
            'Filter' => [
                'foo' => 'bar'
            ]
        ])->offsetExists(0);
    }

    public function testAggregateFilterParameters(): void
    {
        self::$api->debugResponses(function ($response, $endpoint, $request) {
            $request = json_decode($request, true);
            $this->assertEquals(['foo'], $request['Aggregate']['Fields'] ?? null);
        });

        $this->queueResponse('{
            "calendars": [],
            "totalCount": 0
        }');
        $endpoint = new Calendars(self::$api);
        $endpoint->list(null, null, null, ['foo'])->offsetExists(0);
    }
}
