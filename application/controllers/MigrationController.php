<?php

use DataDate\Http\Controller;

class MigrationController extends Controller
{
    public function index()
    {
        $this->ci->load->library('migration');

        if ($this->ci->migration->current() === false) {
            show_error($this->ci->migration->error_string());
        }
    }
}