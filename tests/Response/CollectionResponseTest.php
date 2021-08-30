<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Response;

use PHPUnit\Framework\TestCase;
use Whise\Api\Exception\InvalidDataException;
use Whise\Api\Exception\InvalidPropertyException;
use Whise\Api\Response\ResponseData;
use Whise\Api\Response\CollectionResponse;

class CollectionResponseTest extends TestCase
{
    protected static $responseData;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$responseData = new ResponseData([1, 2, 3]);
    }

    public function testGet(): void
    {
        $object = new CollectionResponse(self::$responseData);

        $this->assertEquals(2, $object->get(1));
    }

    public function testCount(): void
    {
        $object = new CollectionResponse(self::$responseData);

        $this->assertCount(3, $object);
    }

    public function testIsset(): void
    {
        $object = new CollectionResponse(self::$responseData);

        $this->assertTrue(isset($object[2]));
        $this->assertFalse(isset($object[3]));
        $this->assertFalse(isset($object['string']));
    }

    public function testOffsetGet(): void
    {
        $object = new CollectionResponse(self::$responseData);

        $this->assertEquals(3, $object[2]);
    }

    public function testOffsetGetInvalid(): void
    {
        $object = new CollectionResponse(self::$responseData);

        $this->expectNotice();
        $invalid = $object[3];
    }

    public function testIterator(): void
    {
        $object = new CollectionResponse(self::$responseData);

        foreach ($object as $index => $value) {
            $this->assertEquals($value, $index + 1);
        }
    }

    public function testJsonSerialize(): void
    {
        $object = new CollectionResponse(self::$responseData);
        $data = json_decode(json_encode($object), false);

        $this->assertCount(3, $data);
    }
}
