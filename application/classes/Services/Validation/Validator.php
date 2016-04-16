<?php

namespace DataDate\Services\Validation;

use DataDate\Http\Request;

class Validator
{
    /**
     * @var array
     */
    private $errors;
    /**
     * @var Validations
     */
    private $validations;

    /**
     * ValidationService constructor.
     *
     * @param Validations $validations
     */
    public function __construct(Validations $validations)
    {
        $this->validations = $validations;
    }

    /**
     * @param Request $request
     * @param array   $rules
     *
     * @throws ValidationException
     */
    public function validate(Request $request, array $rules)
    {
        $this->errors = [];

        foreach ($rules as $fieldName => $validations) {
            $this->validateField($request, $validations, $fieldName);
        }

        if (!empty($this->errors)) {
            throw new ValidationException($this->errors);
        }
    }

    /**
     * @param Request $request
     * @param         $validations
     * @param         $fieldName
     */
    private function validateField(Request $request, $validations, $fieldName)
    {
        foreach ($this->getValidations($validations) as $validation) {
            $parameters = [];
            if ($this->hasParameters($validation)) {
                $parameters = $this->getParameters($validation);
                $validation = $this->getValidation($validation);
            }
            if ($this->fails($request, $validation, $fieldName, $parameters)) {
                $this->addError($fieldName, $validation, $parameters);
            }
        }
    }

    /**
     * @param       $request
     * @param       $check
     * @param       $name
     * @param array $parameters
     *
     * @return bool
     */
    private function fails($request, $check, $name, array $parameters)
    {
        return !call_user_func_array([$this->validations, $check], array_merge([$name, $request], $parameters));
    }

    /**
     * @param $fieldName
     * @param $validation
     * @param $parameters
     *
     * @return mixed|string
     */
    private function addError($fieldName, $validation, $parameters)
    {
        return $this->errors[$fieldName][] = $this->formatMessage($validation, $fieldName, $parameters);
    }

    /**
     * @param $check
     * @param $name
     *
     * @return mixed|string
     */
    private function formatMessage($check, $name, $parameters)
    {
        return $this->insertParameters($parameters, $this->insertName($name, $this->validations->getMessage($check)));
    }

    /**
     * @param $validation
     *
     * @return mixed
     */
    private function hasParameters($validation)
    {
        return strpos($validation, ':');
    }

    /**
     * @param $validation
     *
     * @return mixed
     */
    private function getValidation($validation)
    {
        $explode = explode(':', $validation);

        return $explode[0];
    }

    /**
     * @param $validation
     *
     * @return mixed
     */
    private function getParameters($validation)
    {
        $explosion = explode(':', $validation);

        return explode(',', $explosion[1]);
    }

    /**
     * @param $validations
     *
     * @return mixed
     */
    private function getValidations($validations)
    {
        return explode('|', $validations);
    }

    /**
     * @param $parameters
     * @param $message
     *
     * @return mixed
     */
    private function insertParameters($parameters, $message)
    {
        foreach ($parameters as $key => $value) {
            $message = str_replace(":$key:", $value, $message);
        }
        return $message;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    private function formatName($name)
    {
        return str_replace('_', ' ', $name);
    }

    /**
     * @param $name
     * @param $message
     *
     * @return mixed
     */
    private function insertName($name, $message)
    {
        return str_replace(':name:', $this->formatName($name), $message);
    }

}