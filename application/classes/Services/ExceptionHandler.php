<?php

namespace DataDate\Services;

use Exception;

class ExceptionHandler
{
    public function handle(Exception $e)
    {
        throw $e;
    }
}