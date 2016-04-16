<?php

namespace DataDate\Database;

use DataDate\Database\Models\Model;

class ModelQuery
{
    /**
     * @var Query
     */
    private $query;
    /**
     * @var Model
     */
    private $model;

    /**
     * ModelQuery constructor.
     *
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    /**
     * @param Model $model
     *
     * @return static
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param      $id
     * @param null $columns
     *
     * @return Model
     */
    public function find($id, $columns = null)
    {
        $this->query->where('id', $id);
        return $this->first($columns);
    }

    /**
     * @param null $columns
     *
     * @return Model
     */
    public function first($columns = null)
    {
        return array_first($this->limit(1)->get($columns));
    }

    /**
     * @param null $columns
     *
     * @return Model[]
     */
    public function get($columns = null)
    {
        $entries = $this->basicQuery()->select($columns);

        foreach ($entries as $key => $entry) {
            $entries[$key] = $this->model->newInstance($entry)->setExists(true);
        }

        return $entries;
    }

    /**
     * @param $attributes
     *
     * @return boolean
     */
    public function insert($attributes)
    {
        $this->model->setExists(true);
        return $this->basicQuery()->insert($attributes, true);
    }

    /**
     * @param $attributes
     *
     * @return array
     */
    public function update($attributes)
    {
        return $this->basicQuery()->update($attributes);
    }

    /**
     * @return Query
     */
    private function basicQuery()
    {
        return $this->query->from($this->model->getTable());
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    function __call($name, $arguments)
    {
        call_user_func_array([$this->query, $name], $arguments);

        return $this;
    }


}