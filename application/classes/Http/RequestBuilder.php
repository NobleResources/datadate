<?php

namespace DataDate\Http;

use DataDate\Session;
use ReflectionParameter;

class RequestBuilder
{
    /**
     * @var \CI_Input
     */
    private $ciInput;
    /**
     * @var Session
     */
    private $session;

    /**
     * ParametersListBuilder constructor.
     *
     * @param \CI_Input $ciInput
     * @param Session   $session
     */
    public function __construct(\CI_Input $ciInput, Session $session)
    {
        $this->ciInput = $ciInput;
        $this->session = $session;
    }

    /**
     * @param $parameters
     *
     * @return Request
     */
    public function build($parameters)
    {
        return new Request($this->ciInput, $this->session, $parameters);
    }
}