<?php

namespace DataDate\Views;

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
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}