<?php

namespace DataDate\Services;

use DataDate\Http\Request;
use DataDate\Http\Responses\Redirect;
use DataDate\Session;

class Redirector
{
    /**
     * @var Session
     */
    private $session;

    /**
     * Redirector constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param string $uri
     *
     * @return Redirect
     */
    public function to($uri)
    {
        $redirect = new Redirect($uri);
        $redirect->setSession($this->session);

        return $redirect;
    }
}