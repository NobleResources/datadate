<?php

namespace DataDate;

use DataDate\Database\Models\User;

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

    public function reflash($name)
    {
        $this->ciSession->keep_flashdata($name);
    }

    /**
     * @param      $name
     * @param null $default
     *
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        $value = $this->ciSession->userdata($name);

        return $value === null ? $default : $value;
    }

    /**
     * @param $name
     * @param $value
     */
    public function store($name, $value)
    {
        $this->ciSession->set_userdata($name, $value);
    }

    /**
     * @param        $name
     * @param string $default
     *
     * @return string
     */
    public function pull($name, $default = null)
    {
        $value = $this->get($name, $default);
        $this->ciSession->unset_userdata($name);

        return $value;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->store('userId', $user->id);
    }


    /**
     * @return User
     */
    public function getUser()
    {
        $userId = $this->get('userId');

        return $userId === null ? null : User::find($userId);
    }

    public function unsetUser()
    {
        $this->ciSession->unset_userdata('userId');
    }

    /**
     * @return boolean
     */
    public function isGuest()
    {
        return $this->getUser() === null;
    }
}