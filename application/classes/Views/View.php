<?php

namespace DataDate\Views;

class View
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var
     */
    public $path;

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
}