<?php

namespace DataDate\Http\Filters;

use Closure;
use DataDate\Http\Request;
use DataDate\Http\Responses\Response;
use DataDate\Services\Redirector;

class AuthenticatesUser implements Filter
{
    /**
     * @var Redirector
     */
    private $redirector;

    /**
     * AuthenticatesUser constructor.
     *
     * @param Redirector $redirector
     */
    public function __construct(Redirector $redirector)
    {
        $this->redirector = $redirector;
    }

    /**
     * @param Request  $request
     * @param Closure $next
     *
     * @return Response
     */
    function handle(Request $request, Closure $next)
    {
        if ($request->isGuest()) {
            return $this->redirector->guest();
        }

        return $next($request);
    }
}