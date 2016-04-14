<?php

use DataDate\Http\Controller;
use DataDate\Http\Filters\AuthenticatesUser;

class Site extends Controller
{
    public function filters()
    {
        return [new AuthenticatesUser($this->redirector)];
    }

    public function index()
    {
        return $this->viewBuilder->build('home');
    }
}
