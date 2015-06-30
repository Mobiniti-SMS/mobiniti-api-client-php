<?php namespace Mobiniti\Api;

class Groups extends AbstractClient
{

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->resource = 'groups';
    }

    /**
     * Retrieve all groups
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
     * Create a new group
     *
     * @param array $data
     *
     * @return object
     */
    public function create(array $data)
    {
        return $this->http->post($this->resource, $data);
    }

    /**
     * Retrieve the group based on the provided id
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
     * Update a group based on the provided id
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

}