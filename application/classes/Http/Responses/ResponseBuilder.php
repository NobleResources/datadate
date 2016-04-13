<?php

namespace DataDate\Http\Responses;

use DataDate\Views\View;
use DataDate\Views\ViewRenderer;

class ResponseBuilder
{
    /**
     * @var ViewRenderer
     */
    private $viewRenderen;

    /**
     * ResponseBuilder constructor.
     *
     * @param ViewRenderer $viewRenderen
     */
    public function __construct(ViewRenderer $viewRenderen)
    {
        $this->viewRenderen = $viewRenderen;
    }

    /**
     * @param mixed $response
     *
     * @return Response
     */
    public function build($response)
    {
        if ($response instanceof Response) {
            return $response;
        }

        if ($response instanceof View) {
            $content = $this->viewRenderen->render($response);
            return new Response($content, 200);
        }

        return new Response($response, 200);
    }
}