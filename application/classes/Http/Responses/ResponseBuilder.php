<?php

namespace DataDate\Http\Responses;

use DataDate\Views\View;
use DataDate\Views\ViewRenderer;

class ResponseBuilder
{
    /**
     * @var ViewRenderer
     */
    private $viewRenderer;

    /**
     * ResponseBuilder constructor.
     *
     * @param ViewRenderer $viewRenderen
     */
    public function __construct(ViewRenderer $viewRenderen)
    {
        $this->viewRenderer = $viewRenderen;
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
            $content = $this->viewRenderer->render($response);
            return new Response($content, 200);
        }

        return new Response($response, 200);
    }
}