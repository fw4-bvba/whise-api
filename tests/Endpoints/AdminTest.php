<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Tests\Endpoints;

use Whise\Api\Tests\ApiTestCase;
use Whise\Api\Endpoints\Admin;
use Whise\Api\Endpoints\AdminClients;
use Whise\Api\Endpoints\AdminOffices;
use Whise\Api\Endpoints\AdminRepresentatives;

class AdminTest extends ApiTestCase
{
    public function testClients(): void
    {
        $endpoint = new Admin(self::$api);
        $this->assertTrue($endpoint->clients() instanceof AdminClients);
    }

    public function testOffices(): void
    {
        $endpoint = new Admin(self::$api);
        $this->assertTrue($endpoint->offices() instanceof AdminOffices);
    }

    public function testRepresentatives(): void
    {
        $endpoint = new Admin(self::$api);
        $this->assertTrue($endpoint->representatives() instanceof AdminRepresentatives);
    }
}
