<?php

namespace DataDate\Services\Validation;

use DataDate\Database\Connection;
use DataDate\Database\Query;

class ValidationService
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var array
     */
    private $messages = [
        'confirmed' => 'The :name: does not match its confirmation.',
        'required' => 'The :name: field is required.',
        'unique' => 'The :name: already exists in our database.',
        'email' => 'The :name: field is not a valid email.',
        'min' => 'The :name: field needs to be a minimum of :0: characters.',
    ];

    /**
     * ValidationService constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $data
     * @param $rules
     *
     * @throws ValidationException
     */
    public function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $name => $validations) {
            foreach (explode('|', $validations) as $validation) {
                $parameters = array();
                if (strpos($validation, ':')) {
                    $validation = explode(':', $validation);
                    $parameters = explode(',', $validation[1]);
                    $validation = $validation[0];
                }

                if ($this->fails($data, $validation, $name, $parameters)) {
                    $errors[$name][] = $this->formatMessage($validation, $name, $parameters);
                }
            }
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }

    /**
     * @param $name
     * @param $attributes
     * @param $minimum
     *
     * @return bool
     */
    private function min($name, $attributes, $minimum)
    {
        return strlen($attributes[$name]) >= $minimum;
    }

    /**
     * @param $name
     * @param $attributes
     * @return bool
     */
    private function required($name, $attributes)
    {
        return isset($attributes[$name]) && !empty($attributes[$name]);
    }

    /**
     * @param $name
     * @param $attributes
     *
     * @return mixed
     */
    private function email($name, $attributes)
    {
        return filter_var($attributes[$name], FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param $name
     * @param $attributes
     *
     * @return bool
     */
    private function confirmed($name, $attributes)
    {
        $confirmationName = $name . '_confirmation';

        return $this->required($confirmationName, $attributes) && $attributes[$confirmationName] === $attributes[$name];
    }

    /**
     * @param $name
     * @param $attributes
     * @param $table
     *
     * @return bool
     */
    private function unique($name, $attributes, $table)
    {
        return ! (new Query($this->connection))->from($table)->where($name, $attributes[$name])->exists();
    }

    /**
     * @param $data
     * @param $check
     * @param $name
     * @param array $parameters
     *
     * @return bool
     */
    private function fails($data, $check, $name, array $parameters)
    {
        return !call_user_func_array([$this, $check], array_merge([$name, $data], $parameters));
    }

    /**
     * @param $check
     * @param $name
     *
     * @return mixed|string
     */
    private function formatMessage($check, $name, $parameters)
    {
        $message = $this->messages[$check];
        $message = str_replace(':name:', $name, $message);

        foreach ($parameters as $key => $value) {
            $message = str_replace(":$key:", $value, $message);
        }

        $message = ucfirst($message);

        return $message;
    }

}