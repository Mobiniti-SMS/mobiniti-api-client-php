<?php namespace Mobiniti\Api;

class Message extends AbstractClient
{

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->resource = 'message';
    }

    /**
     * Send a sms message to one number
     *
     * @param array $data
     *
     * @return object
     */
    public function send(array $data)
    {
        return $this->http->post($this->resource, $data);
    }
    
    /**
     * Schedule a message to one mobile number
     *
     * @param array $data
     *
     * @return object
     */
    public function schedule(array $data)
    {
        return $this->http->post($this->resource.'/schedule', $data);
    }
    
    /**
     *  Send personalized batch
     *
     * @param array $data
     *
     * @return object
     */
    public function batch(array $data)
    {
        return $this->http->post($this->resource.'/batch', $data);
    }

}
