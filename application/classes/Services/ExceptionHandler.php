<?php

namespace DataDate\Services;

use DataDate\Http\Request;
use DataDate\Http\Responses\Response;
use DataDate\Services\Validation\ValidationException;
use Exception;

class ExceptionHandler
{
    /**
     * @var Redirector
     */
    private $redirector;
    /**
     * @var Request
     */
    private $request;

    /**
     * ExceptionHandler constructor.
     *
     * @param Redirector $redirector
     * @param Request    $request
     */
    public function __construct(Redirector $redirector, Request $request)
    {
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * @param Exception $e
     *
     * @return Response
     * @throws Exception
     */
    public function handle(Exception $e)
    {
        if ($e instanceof ValidationException) {
            return $this->redirector
                ->back()
                ->withErrors($e->getErrors())
                ->withOld($this->request->post());
        }

        throw $e;
    }
}