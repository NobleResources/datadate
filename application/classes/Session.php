<?php

namespace DataDate;

class Session
{
    /**
     * @var \CI_Session
     */
    private $ciSession;

    /**
     * Session constructor.
     *
     * @param \CI_Session $ciSession
     */
    private function __construct(\CI_Session $ciSession)
    {
        $this->ciSession = $ciSession;
    }

    /**
     * @return Session
     */
    public static function load()
    {
        $ci =& get_instance();
        $ci->load->library('session');

        return new Session($ci->session);
    }

    /**
     * @param $name
     * @param $value
     */
    public function flash($name, $value)
    {
        $this->ciSession->set_flashdata($name, $value);
    }

    /**
     * @param $name
     *
     * @return null
     */
    public function get($name)
    {
        if (isset($this->ciSession->userdata[$name])) {
            return $this->ciSession->userdata[$name];
        }

        return null;
    }
}