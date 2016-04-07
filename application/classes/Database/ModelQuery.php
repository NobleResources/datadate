<?php

namespace DataDate\Database;

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
     * @param null $columns
     *
     * @return Model[]
     */
    public function get($columns = null)
    {
        $entries = $this->basicQuery()->select($columns);

        foreach ($entries as $key => $entry) {
            $entries[$key] = new Model($entry);
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
        return $this->basicQuery()->insert($attributes);
    }

    /**
     * @return Query
     */
    private function basicQuery()
    {
        return $this->query->from($this->model->getTable());
    }

}