<?php namespace Mobiniti\Api;

class Schedule extends AbstractClient
{

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->resource = 'messages/schedule';
    }

    /**
     * Retrieve all scheduled messages
     *
     * @param int $limit
     * @param int $page
     *
     * @return mixed
     */
    public function all($limit = 100, $page = 1)
    {
        return $this->http->get($this->resource, ['limit' => $limit, 'page' => $page]);
    }

    /**
     * Retrieves the details of a scheduled message that was previously created.
     *
     * @param $id
     *
     * @return object
     */
    public function retrieve($id)
    {
        return $this->http->get("{$this->resource}/{$id}");
    }

    /**
     * Updates the specified scheduled message by setting the values of the parameters passed.
     * Any parameters not provided will be left unchanged.
     *
     * @param $id
     * @param array $data
     *
     * @return object
     */
    public function update($id, array $data)
    {
        return $this->http->put("{$this->resource}/{$id}", $data);
    }
    
    /**
     * Delete the scheduled message that was previously created.
     *
     * @param $id
     *
     * @return object
     */
    public function delete($id)
    {
        return $this->http->delete("{$this->resource}/{$id}");
    }

    /**
     * Send a sms message to a contact
     *
     * @param array $data
     *
     * @return object
     */
    public function create(array $data)
    {
        return $this->http->post($this->resource, $data);
    }

}
