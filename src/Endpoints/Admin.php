<?php

/*
* This file is part of the fw4/whise-api library
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Whise\Api\Endpoints;

use Whise\Api\Endpoint;

final class Admin extends Endpoint
{
    /** @var AdminClients */
    protected $clientsEndpoint;
    
    /** @var AdminOffices */
    protected $officesEndpoint;
    
    /** @var AdminRepresentatives */
    protected $representativesEndpoint;
    
    /**
     * Access endpoints related to clients.
     *
     * @return AdminClients
     */
    public function clients(): AdminClients
    {
        if (is_null($this->clientsEndpoint)) {
            $this->clientsEndpoint = new AdminClients($this->api);
        }
        return $this->clientsEndpoint;
    }
    
    /**
     * Access endpoints related to offices.
     *
     * @return AdminOffices
     */
    public function offices(): AdminOffices
    {
        if (is_null($this->officesEndpoint)) {
            $this->officesEndpoint = new AdminOffices($this->api);
        }
        return $this->officesEndpoint;
    }
    
    /**
     * Access endpoints related to representatives.
     *
     * @return AdminRepresentatives
     */
    public function representatives(): AdminRepresentatives
    {
        if (is_null($this->representativesEndpoint)) {
            $this->representativesEndpoint = new AdminRepresentatives($this->api);
        }
        return $this->representativesEndpoint;
    }
}
