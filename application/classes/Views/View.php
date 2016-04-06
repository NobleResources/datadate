<?php

namespace DataDate\Views;

class View
{
    /**
     * @var string
     */
    private $content;
    /**
     * @var array
     */
    private $errors;

    /**
     * View constructor.
     *
     * @param string $name
     * @param array  $parameters
     * @param array  $errors
     * @param array  $old
     *
     * @throws ViewNotFoundException
     */
    public function __construct($name, $parameters = [], $errors = [], $old = [])
    {
        $this->old = $old;
        $this->errors = $errors;
        $this->content = $this->getContent($name, $parameters);
    }

    /**
     * @return mixed
     */
    public function render()
    {
        return $this->content;
    }

    /**
     * @param $name
     *
     * @return string
     */
    private function getFirstError($name)
    {
        if (isset($this->errors[$name])) {
            return array_first($this->errors[$name]);
        }

        return '';
    }

    /**
     * @param $name
     *
     * @return string
     */
    private function getOld($name)
    {
        if (isset($this->old[$name])) {
            return $this->old[$name];
        }

        return '';
    }

    /**
     * @param $name
     * @param $parameters
     *
     * @return mixed
     * @throws ViewNotFoundException
     */
    private function getContent($name, $parameters)
    {
        $path = $this->getPath($name);
        if (is_file($path)) {
            return $this->parseView($parameters, $path);
        }

        throw new ViewNotFoundException($name);
    }

    /**
     * @param $name
     *
     * @return string
     */
    private function getPath($name)
    {
        return VIEWPATH . str_replace('.', '/', $name) . '.php';
    }

    /**
     * @param $parameters
     * @param $path
     *
     * @return mixed
     */
    private function parseView($parameters, $path)
    {
        ob_start();
        extract($parameters, EXTR_OVERWRITE);
        include $path;

        return ob_get_clean();
    }
}