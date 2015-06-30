<?php namespace Mobiniti\Api\Exceptions;

class MobinitiException extends \Exception
{

    protected $errors = [];

    public function __construct($message, $code, \Exception $previous = null, $errors = [])
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}
