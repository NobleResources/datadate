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
    public function __construct(\CI_Session $ciSession)
    {
        $this->ciSession = $ciSession;
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