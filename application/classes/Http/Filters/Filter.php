<?php

namespace DataDate\Http\Filters;

use DataDate\Http\Request;
use DataDate\Http\Responses\Response;

interface Filter
{
    /**
     * @param Request  $request
     *
     * @param \Closure $next
     *
     * @return Response
     */
    function handle(Request $request, \Closure $next);
}