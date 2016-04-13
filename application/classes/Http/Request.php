<?php

namespace DataDate\Http;

use CI_Input;
use DataDate\Session;
use User;

class Request
{
    /**
     * @var CI_Input
     */
    private $ciInput;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var array
     */
    private $routeParameters;
    
    /**
     * Request constructor.
     *
     * @param CI_Input $ciInput
     * @param Session  $session
     */
    public function __construct(CI_Input $ciInput, Session $session, $parameters)
    {
        $this->ciInput = $ciInput;
        $this->session = $session;
        $this->routeParameters = $parameters;
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function header($name = null)
    {
        if ($name !== null) {
            return $this->ciInput->get_request_header($name, true);
        }

        return $this->ciInput->request_headers(true);
    }

    /**
     * @param null $name
     *
     * @return mixed $name
     */
    public function get($name = null)
    {
        return $this->ciInput->get($name, true);
    }

    /**
     * @param null $name
     *
     * @return mixed
     */
    public function post($name = null)
    {
        return $this->ciInput->post($name, true);
    }

    /**
     * @return null|User
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

    public function uri()
    {
        return $this->ciInput->server('REQUEST_URI');
    }
}