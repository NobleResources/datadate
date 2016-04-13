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
    protected $attributes = [];
    /**
     * @var array
     */
    protected $updated = [];
    /**
     * @var boolean
     */
    protected $exists = false;

    /**
     * Model constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
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

        return new static($instance->save());
    }

    /**
     * @param $attributes
     */
    public function update($attributes)
    {
        $this->setAttributes($attributes);
        return (new static)->newQuery()->update($attributes + ['id' => $this->id]);
    }

    /**
     * @return int
     */
    public function save()
    {
        return (new static)->newQuery()->insert($this->attributes);
    }

    /**
     * @param array $attributes
     *
     * @return static
     */
    public function newInstance($attributes = [])
    {
        return new static($attributes);
    }

    /**
     * @return ModelQuery
     */
    public function newQuery()
    {
        return (new ModelQuery(new Query(static::$connection)))->setModel($this);
    }

    /**
     * @param boolean $exists
     *
     * @return $this
     */
    public function setExists($exists)
    {
        $this->exists = $exists;
        return $this;
    }

    /**
     * @param Connection $connection
     */
    public static function setConnection(Connection $connection)
    {
        static::$connection = $connection;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        $this->updated = array_keys($attributes);
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    function __get($name)
    {
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : null;
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
}