<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests;

use Whise\Api\WhiseApi;
use Whise\Api\Endpoints\Admin;
use Whise\Api\Endpoints\AdminClients;
use Whise\Api\Endpoints\AdminOffices;
use Whise\Api\Endpoints\Estates;
use Whise\Api\Endpoints\Contacts;
use Whise\Api\Endpoints\Calendars;
use Whise\Api\Endpoints\Activities;
use InvalidArgumentException;
use Cache\Adapter\PHPArray\ArrayCachePool;

class WhiseApiTest extends ApiTestCase
{
    public function testSetPageSize(): void
    {
        WhiseApi::setDefaultPageSize(24);
        $this->assertEquals(24, WhiseApi::getDefaultPageSize());
    }

    public function testAccessToken(): void
    {
        $api = new WhiseApi('foo');
        $this->assertEquals('foo', $api->getAccessToken());
    }

    public function testAccessTokenArray(): void
    {
        $api = new WhiseApi([
            'token' => 'foo',
        ]);
        $this->assertEquals('foo', $api->getAccessToken());
    }

    public function testAccessTokenObject(): void
    {
        $api = new WhiseApi((object)[
            'token' => 'foo',
        ]);
        $this->assertEquals('foo', $api->getAccessToken());
    }

    public function testAccessTokenInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $api = new WhiseApi(1);
    }

    public function testToken(): void
    {
        $this->queueResponse('{"foo": "bar"}');
        $response = self::$api->token([]);

        $this->assertEquals('bar', $response->foo);
    }

    public function testAdmin(): void
    {
        $this->assertTrue(self::$api->admin() instanceof Admin);
    }

    public function testClients(): void
    {
        $this->assertTrue(self::$api->clients() instanceof AdminClients);
    }

    public function testOffices(): void
    {
        $this->assertTrue(self::$api->offices() instanceof AdminOffices);
    }

    public function testEstates(): void
    {
        $this->assertTrue(self::$api->estates() instanceof Estates);
    }

    public function testContacts(): void
    {
        $this->assertTrue(self::$api->contacts() instanceof Contacts);
    }

    public function testCalendars(): void
    {
        $this->assertTrue(self::$api->calendars() instanceof Calendars);
    }

    public function testActivities(): void
    {
        $this->assertTrue(self::$api->activities() instanceof Activities);
    }

    public function testRequestAccessToken(): void
    {
        $this->queueResponse('{"foo": "bar"}');
        $response = self::$api->requestAccessToken('username', 'password');

        $this->assertEquals('bar', $response->foo);
    }

    public function testRequestClientToken(): void
    {
        $this->queueResponse('{"foo": "bar"}');
        $response = self::$api->requestClientToken(1, 1);

        $this->assertEquals('bar', $response->foo);
    }

    public function testCache(): void
    {
        $cache = new ArrayCachePool();
        $adapter = new TestApiAdapter();
        $api = new WhiseApi();
        $api->setApiAdapter($adapter);

        $api->setCache($cache, 100, 'test');

        $this->assertEquals($cache, $adapter->getCache());
        $this->assertEquals(100, $adapter->getCacheTtl());
        $this->assertEquals('test', $adapter->getCachePrefix());

        $date = new \DateTime('+1 year');
        $api->setCacheTtl($date);
        $this->assertEquals($date, $adapter->getCacheTtl());

        $api->setCachePrefix('foo');
        $this->assertEquals('foo', $adapter->getCachePrefix());
    }
}
