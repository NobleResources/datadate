<?php

namespace DataDate\Http\Exceptions;

class NotFoundException extends HttpException
{
    /**
     * NotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('404: Page not found', 404);
    }
}