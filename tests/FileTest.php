<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests;

use PHPUnit\Framework\TestCase;
use Whise\Api\File;
use SplFileInfo;
use InvalidArgumentException;

class FileTest extends TestCase
{
    static protected $filePath;
    
    static public function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$filePath = rtrim(__DIR__, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'testfile.txt';
    }
    
    public function testFilePathConstructor(): void
    {
        $file = new File(self::$filePath);
        
        $this->assertTrue(is_resource($file->getFileResource()));
        
        unset($file);
    }
    
    public function testSplFileInfoConstructor(): void
    {
        $fileinfo = new SplFileInfo(self::$filePath);
        $file = new File($fileinfo);
        
        $this->assertTrue(is_resource($file->getFileResource()));
        
        unset($file);
    }
    
    public function testResourceConstructor(): void
    {
        $handle = fopen(self::$filePath, 'r');
        $file = new File($handle);
        
        $this->assertTrue(is_resource($file->getFileResource()));
        
        unset($file);
    }
    
    public function testInvalidConstructor(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $file = new File(10);
    }
    
    public function testMetadata(): void
    {
        $file = new File(self::$filePath, [
            'foo' => 'bar'
        ], 'filename.txt');
        
        $this->assertEquals([
            'foo' => 'bar',
            'file' => 'filename.txt',
        ], $file->getMetadata());
        
        unset($file);
    }
}
