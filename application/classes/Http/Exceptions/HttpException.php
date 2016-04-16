<?php

namespace DataDate\Http\Exceptions;

use DataDate\Http\Responses\Response;
use Exception;

abstract class HttpException extends Exception
{
    public function toResponse()
    {
        return new Response($this->getMessage(), $this->getCode());
    }
}