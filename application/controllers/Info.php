<?php

use DataDate\Http\Controller;

class Info extends Controller
{
    public function index()
    {
        phpinfo();
    }
}