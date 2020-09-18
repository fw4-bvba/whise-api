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

class WhiseApiTest extends ApiTestCase
{
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
}
