<?php

use Extensions\BaseController;

class Info extends BaseController
{
    public function index()
    {
        phpinfo();
    }
}