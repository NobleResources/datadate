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
        return new Redirect($this->session, $uri);
    }

    /**
     * @return Redirect
     */
    public function back()
    {
        return $this->to($this->request->header('referer'));
    }

    /**
     * @return Redirect
     */
    public function guest()
    {
        $this->session->flash('intended', $this->request->uri());

        return $this->to('signin');
    }

    /**
     * @return Redirect
     */
    public function intended()
    {
        return $this->to($this->session->pull('intended', '/'));
    }
}