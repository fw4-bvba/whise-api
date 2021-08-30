<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Endpoints\EstatesExports;
use Whise\Api\Enums\ExportStatus;

class EstatesExportsTest extends ApiTestCase
{
    public function testList(): void
    {
        $endpoint = new EstatesExports(self::$api);

        $this->queueResponse('{
            "estates": [1, 2, 3],
            "totalCount": 3
        }');

        self::$adapter->debugResponses(function ($response_body, $endpoint, $request_body) {
            $request = json_decode($request_body, true);
            unset($request['Page']);
            $this->assertEquals([
                'OfficeId' => 123,
                'ShowRepresentatives' => false,
                'IsReset' => true,
            ], $request);
        });

        $items = $endpoint->list(123, false, true);

        $this->assertCount(3, $items);
    }

    public function testChangeStatus(): void
    {
        $endpoint = new EstatesExports(self::$api);

        $this->queueResponse('{}');

        self::$adapter->debugResponses(function ($response_body, $endpoint, $request_body) {
            $request = json_decode($request_body, true);
            $this->assertEquals([
                'EstateId' => 123,
                'ExportStatus' => 11,
                'IdInMedia' => '456',
                'ExportMessage' => 'foo',
            ], $request);
        });

        $response = $endpoint->changeStatus(123, ExportStatus::DeleteRequestConfirmedByMedia, 456, 'foo');

        $this->assertNull($response);
    }
}
