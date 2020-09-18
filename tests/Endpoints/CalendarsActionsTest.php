<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Endpoints\CalendarsActions;

class CalendarsActionsTest extends ApiTestCase
{
    public function testList(): void
    {
        $endpoint = new CalendarsActions(self::$api);
        
        $this->queueResponse('{
            "actions": [1, 2, 3],
            "totalCount": 3
        }');
        $items = $endpoint->list();
        
        $this->assertCount(3, $items);
    }
}
