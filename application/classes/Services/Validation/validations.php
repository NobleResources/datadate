<?php

namespace DataDate\Services\Validation;

use DataDate\Database\Connection;
use DataDate\Database\Query;
use DataDate\Http\Request;

class Validations
{
    /**
     * @var array
     */
    private $messages = [
        'image'     => 'The :name: has to be an image',
        'confirmed' => 'The :name: does not match its confirmation',
        'required'  => 'The :name: field is required',
        'unique'    => 'The :name: already exists in our database',
        'email'     => 'The :name: field is not a valid email',
        'min'       => 'The :name: field needs to be at least :0: characters long',
        'max'       => 'The :name: field can not be longer than :0: characters',
        'between'   => 'The :name: field has to be between :0: and :1: characters long',
    ];
    /**
     * @var Connection
     */
    private $connection;

    /**
     * Validations constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param         $name
     * @param Request $request
     *
     * @return bool
     */
    public function image($name, Request $request)
    {
        $file = $request->file($name);

        return $file === null || $file->isImage();
    }

    /**
     * @param string  $name
     * @param Request $request
     * @param         $minimum
     *
     * @return bool
     */
    public function min($name, Request $request, $minimum)
    {
        return strlen($request->$name) >= $minimum;
    }

    /**
     * @param string  $name
     * @param Request $request
     * @param         $maximum
     *
     * @return bool
     */
    public function max($name, Request $request, $maximum)
    {
        return strlen($request->$name) <= $maximum;
    }

    /**
     * @param string  $name
     * @param Request $request
     * @param         $minimum
     * @param         $maximum
     *
     * @return bool
     */
    public function between($name, Request $request, $minimum, $maximum)
    {
        return $this->min($name, $request, $minimum) && $this->max($name, $request, $maximum);
    }

    /**
     * @param string  $name
     * @param Request $request
     *
     * @return bool
     */
    public function required($name, Request $request)
    {
        return isset($request->$name) && !empty($request->$name);
    }

    /**
     * @param string  $name
     * @param Request $request
     *
     * @return mixed
     */
    public function email($name, Request $request)
    {
        return filter_var($request->$name, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param string  $name
     * @param Request $request
     *
     * @return bool
     */
    public function confirmed($name, Request $request)
    {
        $confirmationName = $name . '_confirmation';

        return $this->required($confirmationName, $request) && $request->$confirmationName === $request->$name;
    }

    /**
     * @param string  $name
     * @param Request $request
     * @param         $table
     *
     * @return bool
     */
    public function unique($name, Request $request, $table)
    {
        return !(new Query($this->connection))->from($table)->where($name, $request->$name)->exists();
    }

    public function getMessage($name)
    {
        return isset($this->messages[$name]) ? $this->messages[$name] : "Validation '$name' does not have a message.";
    }
}