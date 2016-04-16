<?php

namespace DataDate\Http;

use DataDate\Database\Connection;
use DataDate\Database\Models\Model;
use DataDate\Http\Filters\Filter;
use DataDate\Http\Request;
use DataDate\Http\Responses\Response;
use DataDate\Http\Responses\ResponseBuilder;
use DataDate\Services\ExceptionHandler;
use DataDate\Services\Redirector;
use DataDate\Services\UrlGenerator;
use DataDate\Services\Validation\Validations;
use DataDate\Services\Validation\Validator;
use DataDate\Session;
use DataDate\Views\HtmlHelper;
use DataDate\Views\View;
use DataDate\Views\ViewBuilder;
use DataDate\Views\ViewRenderer;
use Exception;

abstract class Controller
{
    /**
     * @var \CI_Controller
     */
    protected $ci;
    /**
     * @var Session
     */
    protected $session;
    /**
     * @var Validator
     */
    protected $validator;
    /**
     * @var Redirector
     */
    protected $redirector;
    /**
     * @var ViewBuilder
     */
    protected $viewBuilder;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->ci = new \CI_Controller();

        $this->ci->load->library('session');
        $this->ci->load->database();

        $connection = new Connection($this->ci->db);
        Model::setConnection($connection);

        $this->session = new Session($this->ci->session);
        $this->validator = new Validator(new Validations($connection));

    }

    /**
     * @param string $method
     * @param array $parameters
     */
    public function _remap($method, $parameters = [])
    {
        $request = new Request($this->session, $parameters);
        $urlGenerator = new UrlGenerator($request, $this->ci->config->base_url());
        $responseBuilder = new ResponseBuilder(new ViewRenderer(new HtmlHelper(), $urlGenerator));
        $this->redirector = new Redirector($urlGenerator, $this->session, $request);
        $this->viewBuilder = new ViewBuilder($this->session, $request);
        $exceptionHandler = new ExceptionHandler($this->redirector, $request);

        $requestStack = new RequestStack($request, [$this, $method], $this->filters());
        try {
            $responseBuilder->build($requestStack->run())->send();
        } catch (Exception $exception) {
            $exceptionHandler->handle($exception)->send();
        }
    }

    /**
     * @return Filter[]
     */
    public function filters()
    {
        return [];
    }
}