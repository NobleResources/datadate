<?php

namespace DataDate\Http;

class Request
{
    /**
     * @var array
     */
    private $headers;
    /**
     * @var array
     */
    private $post;

    /**
     * Request constructor.
     *
     * @param array $headers
     * @param array $post
     */
    private function __construct(array $headers, array $post)
    {
        $this->headers = $headers;
        $this->post = $post;
    }

    /**
     * @return Request
     */
    public static function load()
    {
        return new Request(getallheaders(), $_POST);
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function getHeader($name)
    {
        if (isset($this->headers[$name])) {
            return $this->headers[$name];
        }

        return null;
    }

    public function all()
    {
        return $this->post;
    }

    /**
     * @param $keys
     */
    public function except($keys)
    {
        return array_except($this->all(), $keys);
    }
}