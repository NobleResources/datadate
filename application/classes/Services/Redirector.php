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
     * @var Request
     */
    private $request;

    /**
     * Redirector constructor.
     *
     * @param Session $session
     * @param Request $request
     */
    public function __construct(Session $session, Request $request)
    {
        $this->session = $session;
        $this->request = $request;
    }

    /**
     * @param string $uri
     *
     * @return Redirect
     */
    public function to($uri)
    {
        return $this->createRedirect($uri);
    }

    /**
     * @return Redirect
     */
    public function back()
    {
        return $this->createRedirect($this->request->header('referer'));
    }

    /**
     * @param $uri
     *
     * @return Redirect
     */
    private function createRedirect($uri)
    {
        $redirect = new Redirect($uri);
        $redirect->setSession($this->session);
        return $redirect;
    }
}