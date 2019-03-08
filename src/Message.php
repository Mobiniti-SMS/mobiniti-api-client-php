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
     *  Send personalized batch
     *
     * @link https://api.mobiniti.com/v1/docs#message-message-batch-send-a-batch-of-messages
     *
     * @param array $data
     *
     * @return object
     */
    public function batch(array $data)
    {
        return $this->http->post($this->resource.'/batch', $data);
    }
    
    /**
     * Schedule a messages
     *
     * @link https://api.mobiniti.com/v1/docs#scheduled-messages
     *
     * @return Schedule
     */
    public function schedule()
    {
        return $this->schedule;
    }

    /**
     * Send a sms message to one number
     *
     * @link https://api.mobiniti.com/v1/docs#message-message-send-an-individual-message
     *
     * @param array $data
     *
     * @return object
     */
    public function send(array $data)
    {
        return $this->http->post($this->resource, $data);
    }

}
