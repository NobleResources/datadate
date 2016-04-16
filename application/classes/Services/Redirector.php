<?php

namespace DataDate\Services;

use DataDate\Http\Request;
use DataDate\Http\Responses\RedirectResponse;
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
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * Redirector constructor.
     *
     * @param UrlGenerator $urlGenerator
     * @param Session      $session
     * @param Request      $request
     */
    public function __construct(UrlGenerator $urlGenerator, Session $session, Request $request)
    {
        $this->session = $session;
        $this->request = $request;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param string $uri
     *
     * @return RedirectResponse
     */
    public function to($uri)
    {
        return new RedirectResponse($this->session, $this->urlGenerator->generate($uri));
    }

    /**
     * @return RedirectResponse
     */
    public function back()
    {
        return $this->to($this->request->header('referer'));
    }

    /**
     * @return RedirectResponse
     */
    public function guest()
    {
        $this->session->flash('intended', $this->request->uri());

        return $this->to('/signin');
    }

    /**
     * @param string $default
     *
     * @return RedirectResponse
     */
    public function intended($default = '/')
    {
        return $this->to($this->session->pull('intended', $default));
    }
}