<?php namespace Mobiniti\Api;

class Debug
{

    protected $request_id;

    /**
     * Set the request id
     *
     * @param $request_id
     *
     * @return $this
     */
    public function setRequestId($request_id) {
        $this->request_id = $request_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestId() {
        return $this->request_id;
    }

}