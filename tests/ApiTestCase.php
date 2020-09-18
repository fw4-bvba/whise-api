<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests;

use PHPUnit\Framework\TestCase;
use Whise\Api\WhiseApi;

abstract class ApiTestCase extends TestCase
{
    static protected $adapter;
    static protected $api;
    
    static public function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$adapter = new TestApiAdapter();
        self::$api = new WhiseApi();
        self::$api->setApiAdapter(self::$adapter);
    }
        
    protected function setUp(): void
    {
        parent::setUp();

        self::$adapter->clearQueue();
        self::$adapter->debugResponses(null);
    }
    
    public function queueResponse($body): void
    {
        if (!is_string($body)) {
            $body = json_encode($body);
        }
        self::$adapter->queueResponse($body);
    }
}
