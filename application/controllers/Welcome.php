<?php

use Extensions\BaseController;

class Welcome extends BaseController
{
    public function index()
    {
        $this->load->view('welcome_message');
    }
}
