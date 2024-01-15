<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Endpoints\Activities;

class ActivitiesTest extends ApiTestCase
{
    public function testCalendars(): void
    {
        $endpoint = new Activities(self::$api);

        $this->queueResponse('{
            "activities": [1, 2, 3],
            "totalCount": 3
        }');
        $items = $endpoint->calendars();

        $this->assertCount(3, $items);
    }

    public function testHistories(): void
    {
        $endpoint = new Activities(self::$api);

        $this->queueResponse('{
            "activities": [1, 2, 3],
            "totalCount": 3
        }');
        $items = $endpoint->histories();

        $this->assertCount(3, $items);
    }

    public function testAudits(): void
    {
        $endpoint = new Activities(self::$api);

        $this->queueResponse('{
            "activities": [1, 2, 3],
            "totalCount": 3
        }');
        $items = $endpoint->audits();

        $this->assertCount(3, $items);
    }

    public function testHistoryExports(): void
    {
        $endpoint = new Activities(self::$api);

        $this->queueResponse('{
            "activities": [1, 2, 3],
            "totalCount": 3
        }');
        $items = $endpoint->historyExports();

        $this->assertCount(3, $items);
    }
}
