<?php namespace Mobiniti\Api\Exceptions;

class OauthException extends MobinitiException
{

    public function __construct($message = '', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}