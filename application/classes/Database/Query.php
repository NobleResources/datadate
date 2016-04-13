<?php

namespace DataDate\Database;

class Query
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var string
     */
    private $table;
    /**
     * @var array
     */
    private $where;
    /**
     * @var int
     */
    private $limit;

    /**
     * Query constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $table
     *
     * @return $this
     */
    public function from($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param $column
     * @param $value
     *
     * @return $this
     */
    public function where($column, $value = null)
    {
        $wheres = isset($value) ? [$column => $value] : $column;

        foreach ($wheres as $column => $value) {
            $this->where[] = sprintf('%s = %s', $this->formatColumn($column), $this->formatValue($value));
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return $this->count() > 0;
    }

    /**
     * @return int
     */
    public function count()
    {
        return (int) $this->connection->runQuery($this->buildCount())[0]['count'];
    }

    /**
     * @param null $columns
     *
     * @return array
     */
    public function select($columns = null)
    {
        return $this->connection->runQuery($this->buildSelect($columns));
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param      $attributes
     * @param bool $returnInserted
     *
     * @return mixed
     */
    public function insert($attributes, $returnInserted = false)
    {
        $result = $this->connection->runQuery($this->buildInsert($attributes));

        if ($returnInserted) {
            $result = array_first($this->where($attributes)->limit(1)->select());
        }

        return $result;
    }

    public function update($attributes)
    {
        return $this->connection->runQuery($this->buildUpdate($attributes));
    }

    /**
     * @param $attributes
     *
     * @return mixed
     */
    private function buildInsert($attributes)
    {
        return sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            $this->buildColumns(array_keys($attributes)),
            $this->buildValues($attributes)
        );
    }

    private function buildUpdate($attributes)
    {
        $id = (int) $attributes['id'];
        unset($attributes['id']);

        return sprintf("UPDATE %s SET %s WHERE `id` = %d",
            $this->table,
            $this->buildSet($attributes),
            $id);
    }

    /**
     * @return mixed
     */
    private function buildCount()
    {
        return sprintf('SELECT count(*) as `count` FROM %s WHERE %s', $this->table, $this->buildWhere());
    }

    /**
     * @param $columns
     *
     * @return string
     */
    private function buildSelect($columns)
    {
        $select = $this->buildColumns($columns);

        $where = $this->buildWhere();

        return sprintf('SELECT %s FROM %s WHERE %s', $select, $this->table, $where);
    }

    /**
     * @param $attributes
     *
     * @return mixed
     */
    private function buildSet($attributes)
    {
        foreach ($attributes as $column => $value) {
            $attributes[$column] = $this->formatAssignment($value, $column);
        }

        return implode(',', $attributes);
    }

    /**
     * @param $attributes
     */
    private function buildValues($attributes)
    {
        return implode(',', array_map([$this, 'formatValue'], $attributes));
    }

    /**
     * @param $columns
     *
     * @return string
     */
    private function buildColumns($columns)
    {
        if ($columns === null) {
            return '*';
        }

        return implode(',', array_map([$this, 'formatColumn'], $columns));
    }

    /**
     * @return string
     */
    private function buildWhere()
    {
        return implode(' AND ', $this->where);
    }

    /**
     * @param $value
     * @param $column
     *
     * @return mixed
     */
    public function formatAssignment($value, $column)
    {
        return sprintf('%s=%s', $this->formatColumn($column), $this->formatValue($value));
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function formatValue($value)
    {
        return "'$value'";
    }

    /**
     * @param string $column
     *
     * @return string
     */
    private function formatColumn($column)
    {
        return "`$column`";
    }

}