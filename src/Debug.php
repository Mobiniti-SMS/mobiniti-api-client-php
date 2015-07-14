<?php namespace Mobiniti\Api;

class Debug
{

    protected $request_id;

    public function setRequestId($request_id) {
        $this->request_id = $request_id;
    }

    public function getRequestId() {
        return $this->request_id;
    }

}