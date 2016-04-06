<?php

use Extensions\BaseController;

class Migrate extends BaseController
{
    public function index()
    {
        $this->load->library('migration');
        if ($this->migration->current() === false) {
            show_error($this->migration->error_string());
        }
    }
}