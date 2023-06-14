<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Endpoints\EstatesDetails;

class EstatesDetailsTest extends ApiTestCase
{
    public function testList(): void
    {
        $endpoint = new EstatesDetails(self::$api);

        $this->queueResponse('{
            "purposeAndCategory": [1, 2],
            "subdetails": [1, 2, 3],
            "totalCount": 3
        }');
        $response = $endpoint->list();

        $this->assertCount(2, $response->purposeAndCategory);
        $this->assertCount(3, $response->subdetails);
    }
}
