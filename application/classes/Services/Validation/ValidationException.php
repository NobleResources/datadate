<?php

namespace DataDate\Services\Validation;

class ValidationException extends \Exception
{
    private $errors;

    /**
     * ValidationException constructor.
     *
     * @param string $errors
     */
    public function __construct($errors)
    {
        $this->errors = $errors;
    }
}