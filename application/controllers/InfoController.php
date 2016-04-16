<?php

use DataDate\Http\Controller;

class InfoController extends Controller
{
    public function index()
    {
        phpinfo();
    }
}