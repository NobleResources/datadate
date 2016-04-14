<?php

namespace DataDate\Views;


use DataDate\Http\Request;
use DataDate\Session;

class ViewBuilder
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
     * ViewBuilder constructor.
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
     * @param $name
     * @param $data
     *
     * @return View
     * @throws ViewNotFoundException
     */
    public function build($name, $data = [])
    {
        $path = $this->getPath($name);
        if (is_file($path)) {
            return new View($path, $this->buildData($data));
        }

        throw new ViewNotFoundException($name);
    }

    /**
     * @param $name
     *
     * @return string
     */
    private function getPath($name)
    {
        return VIEWPATH . str_replace('.', '/', $name) . '.php';
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    private function buildData($data)
    {
        return $data + [
            'errors' => $this->session->get('errors'),
            'user' => $this->session->getUser(),
            'old' => $this->session->get('old'),
            'uri' => $this->request->uri(),
        ];
    }

}