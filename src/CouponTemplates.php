<?php namespace Mobiniti\Api;

class CouponTemplates extends AbstractClient
{
    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->resource = 'coupon_templates';
    }

    /**
     * Retrieve all coupon templates
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
     * Retrieve the coupon template based on the provided id
     *
     * @param $id
     *
     * @return object
     */
    public function retrieve($id)
    {
        return $this->http->get("{$this->resource}/{$id}");
    }

}