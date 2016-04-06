<?php

namespace DataDate\Http\Responses;

use DataDate\Session;

class Redirect extends Response
{
    /**
     * @var Session
     */
    private $session;

    /**
     * Redirect constructor.
     *
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct('', 302, ['Location' => $uri]);
    }

    /**
     * @param array $errors
     *
     * @return $this
     */
    public function withErrors(array $errors)
    {
        $this->session->flash('errors', $errors);

        return $this;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function withOld(array $values)
    {
        $this->session->flash('old', $values);

        return $this;
    }

    /**
     * @param Session $session
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
    }
}