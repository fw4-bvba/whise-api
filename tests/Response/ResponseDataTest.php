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

class ResponseDataTest extends TestCase
{
    public function testGetMetadata(): void
    {
        $input = (object)[
            'foo' => 10
        ];
        $object = new ResponseData([], $input);
        $metadata = $object->getMetadata();
        
        $this->assertIsArray($metadata);
        $this->assertArrayHasKey('foo', $metadata);
        $this->assertEquals(10, $metadata['foo']);
    }
    
    public function testInvalidData(): void
    {
        $this->expectException(InvalidDataException::class);
        $object = new ResponseData([], 'test');
    }
    
    public function testMetadata(): void
    {
        $input = (object)[
            'foo' => 10
        ];
        $object = new ResponseData([], $input);
        
        $this->assertEquals(10, $object->metadata('foo'));
    }
    
    public function testMissingMetadata(): void
    {
        $this->expectException(InvalidPropertyException::class);
        
        $input = (object)[];
        $object = new ResponseData([], $input);
        
        $invalid = $object->metadata('invalid');
    }
}
