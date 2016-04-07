<?php

namespace DataDate\Database;

use CI_DB;

class Model
{
    /**
     * @var Connection
     */
    protected static $connection;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * Model constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return strtolower(get_class($this));
    }

    /**
     * @return mixed
     */
    public static function all()
    {
        return (new static)->newQuery()->get();
    }

    /**
     * @param $attributes
     *
     * @return mixed
     */
    public static function create($attributes)
    {
        $instance = new static($attributes);
        $instance->save();

        return $instance;
    }

    /**
     * @return boolean
     */
    public function save()
    {
        return (new static)->newQuery()->insert($this->attributes);
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $query = $this->newQuery();

        return call_user_func_array([$query, $name], $arguments);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $instance = new static;

        return call_user_func_array([$instance, $name], $arguments);
    }

    /**
     * @param Connection $connection
     */
    public static function setConnection(Connection $connection)
    {
        static::$connection = $connection;
    }

    /**
     * @return ModelQuery
     */
    public function newQuery()
    {
        return (new ModelQuery(new Query(static::$connection)))->setModel($this);
    }
}