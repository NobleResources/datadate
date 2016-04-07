<?php

namespace DataDate\Http;

use CI_Input;

class Request
{
    /**
     * @var CI_Input
     */
    private $ciInput;

    /**
     * Request constructor.
     *
     * @param CI_Input $ciInput
     */
    public function __construct(CI_Input $ciInput)
    {
        $this->ciInput = $ciInput;
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
}