<?php namespace Mobiniti\Api;

class Message extends AbstractClient
{

    protected $schedule;
    
    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
        
        $this->schedule = new Schedule($client);

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
     * Schedule a messages
     *
     * @return Schedule
     */
    public function schedule()
    {
        return $this->schedule;
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
