<?php namespace Mobiniti\Api;

abstract class AbstractClient
{

    protected $errors;

    protected $client;
    
    protected $http;

    protected $resource;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->http = new Http($client);
    }

}
