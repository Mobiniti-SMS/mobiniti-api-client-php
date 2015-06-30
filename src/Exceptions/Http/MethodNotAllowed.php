<?php namespace Mobiniti\Api\Exceptions\Http;

use Mobiniti\Api\Exceptions\MobinitiException;

class MethodNotAllowedException extends MobinitiException
{

    public function __construct($message, $code, \Exception $previous = null, $errors = [])
    {
        parent::__construct($message, $code, $previous);
    }

}