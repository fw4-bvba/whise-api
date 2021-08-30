<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\File;
use Whise\Api\Endpoints\EstatesDocuments;
use InvalidArgumentException;

class EstatesDocumentsTest extends ApiTestCase
{
    protected static $filePath;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$filePath = rtrim(dirname(__DIR__), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'testfile.txt';
    }

    public function testUpload(): void
    {
        $endpoint = new EstatesDocuments(self::$api);
        $file = new File(self::$filePath);

        $this->queueResponse('{
            "documents": [1, 2, 3]
        }');
        $items = $endpoint->upload(1, $file);

        $this->assertCount(3, $items);
    }

    public function testUploadFilePath(): void
    {
        $endpoint = new EstatesDocuments(self::$api);

        $this->queueResponse('{
            "documents": [1, 2, 3]
        }');
        $items = $endpoint->upload(1, self::$filePath);

        $this->assertCount(3, $items);
    }

    public function testUploadInvalid(): void
    {
        $endpoint = new EstatesDocuments(self::$api);

        $this->expectException(InvalidArgumentException::class);
        $items = $endpoint->upload(1, 1);
    }

    public function testDelete(): void
    {
        $endpoint = new EstatesDocuments(self::$api);

        $this->queueResponse('{"foo": "bar"}');
        $response = $endpoint->delete(1, 1);

        $this->assertEquals('bar', $response->foo);
    }
}
