<?php

namespace NoCake\FormBuilder\Exception;

use Throwable;

class ValidationException extends \Exception
{
    protected $errors = [];

    public function __construct($message = "Validation errors", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public static function create(array $errors)
    {
        $instance = new static();
        $instance->setErrors($errors);
        return $instance;
    }
}