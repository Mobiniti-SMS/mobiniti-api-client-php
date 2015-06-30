<?php namespace Mobiniti\Api;

class Coupons extends AbstractClient
{

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->resource = 'coupons';
    }

    /**
     * Retrieve all coupons
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
     * Create a new coupon
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
     * Retrieve the coupon based on the provided id
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
     * Update a coupon based on the provided id
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