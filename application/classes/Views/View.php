<?php

namespace DataDate\Views;

use DataDate\Database\Models\Model;

class View
{
    /**
     * @var array
     */
    private $data;
    /**
     * @var
     */
    private $path;

    /**
     * View constructor.
     *
     * @param       $path
     * @param array $data
     */
    public function __construct($path, $data = [])
    {
        $this->data = $data;
        $this->path = $path;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        if (isset($this->data['errors'])) {
            return $this->data['errors'];
        }

        return [];
    }

    /**
     * @return array
     */
    public function getOld()
    {
        if (isset($this->data['old'])) {
            return $this->data['old'];
        }

        return [];
    }

    /**
     * @return Model|null
     */
    public function getModel()
    {
        if (isset($this->data['model'])) {
            return $this->data['model'];
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}