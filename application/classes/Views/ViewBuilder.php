<?php

namespace DataDate\Views;


use DataDate\Session;

class ViewBuilder
{
    /**
     * @var Session
     */
    private $session;

    /**
     * ViewBuilder constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
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
            return new View($path, $this->addOldAndErrors($data));
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
    private function addOldAndErrors($data)
    {
        return $data + [
            'errors' => $this->session->get('errors'),
            'old' => $this->session->get('old'),
        ];
    }

}