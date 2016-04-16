<?php

namespace DataDate\Http;

use DataDate\File;
use DataDate\Session;
use DataDate\Database\Models\User;

class Request
{
    /**
     * @var array
     */
    private $get;
    /**
     * @var array
     */
    private $post;
    /**
     * @var array
     */
    private $files;
    /**
     * @var array
     */
    private $headers;
    /**
     * @var array
     */
    private $server;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var array
     */
    private $parameters;

    /**
     * Request constructor.
     *
     * @param Session     $session
     * @param array       $parameters
     */
    public function __construct(Session $session, array $parameters)
    {
        $this->session = $session;
        $this->parameters = $parameters;

        $this->server = $_SERVER;
        $this->headers = getallheaders();
        $this->files = array_filter($_FILES, function ($description) { return $description['size'] > 0; });
        $this->post = $_POST;
        $this->get = $_GET;
    }

    /**
     * @param null $name
     * @param null $default
     *
     * @return array|mixed|null
     */
    public function header($name = null, $default = null)
    {
        if (!isset($name)) {
            return $this->headers;
        }

        if (isset($this->headers[$name])) {
            return $this->headers[$name];
        }

        return $default;
    }

    /**
     * @param null $name
     * @param null $default
     *
     * @return array|mixed|null
     */
    public function get($name = null, $default = null)
    {
        if (!isset($name)) {
            return $this->get;
        }

        if (isset($this->get[$name])) {
            return $this->get[$name];
        }

        return $default;
    }

    /**
     * @param null $name
     * @param null $default
     *
     * @return array|mixed|null
     */
    public function post($name = null, $default = null)
    {
        if (!isset($name)) {
            return $this->post;
        }

        if (isset($this->post[$name])) {
            return $this->post[$name];
        }

        return $default;
    }

    /**
     * @param null $name
     * @param null $default
     *
     * @return array|mixed|null
     */
    public function parameter($name = null, $default = null)
    {
        if (!isset($name)) {
            return $this->parameters;
        }

        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        }

        return $default;
    }

    /**
     * @param null $name
     *
     * @return File|null
     */
    public function file($name = null)
    {
        if (!isset($name)) {
            return array_map([$this, 'file'], array_keys($this->files));
        }

        if (isset($this->files[$name])) {
            return File::fromDescription($this->files[$name]);
        }

        return null;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->session->getUser();
    }

    /**
     * @return bool
     */
    public function isGuest()
    {
        return $this->session->isGuest();
    }

    /**
     * @return string
     */
    public function uri()
    {
        return isset($this->server['REQUEST_URI']) ? $this->server['REQUEST_URI'] : '';
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->post($name, $this->get($name, null));
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->post[$name]) || isset($this->get[$name]) || isset($this->files[$name]);
    }
}