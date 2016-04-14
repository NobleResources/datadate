<?php

namespace DataDate\Http;

use DataDate\Database\Connection;
use DataDate\Database\Model;
use DataDate\Http\Filters\Filter;
use DataDate\Http\Request;
use DataDate\Http\Responses\Response;
use DataDate\Http\Responses\ResponseBuilder;
use DataDate\Services\ExceptionHandler;
use DataDate\Services\Redirector;
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
     * @var ExceptionHandler
     */
    private $exceptionHandler;
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
     * @var ResponseBuilder
     */
    private $responseBuilder;
    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->ci = new \CI_Controller();

        $this->ci->load->library('session');
        $this->ci->load->model('user');
        $this->ci->load->database();

        $connection = new Connection($this->ci->db);
        Model::setConnection($connection);

        $this->session = new Session($this->ci->session);

        $this->validator = new Validator($connection);

        $this->requestBuilder = new RequestBuilder($this->ci->input, $this->session);
        $this->responseBuilder = new ResponseBuilder(new ViewRenderer(new HtmlHelper()));

    }

    /**
     * @param string $method
     * @param array $parameters
     */
    public function _remap($method, $parameters = [])
    {
        $request = $this->requestBuilder->build($parameters);
        $this->viewBuilder = new ViewBuilder($this->session, $request);
        $this->redirector = new Redirector($this->session, $request);
        $this->exceptionHandler = new ExceptionHandler($this->redirector, $request);

        $requestStack = new RequestStack($request, [$this, $method], $this->filters());

        try {
            $this->responseBuilder->build($requestStack->run())->send();
        } catch (Exception $exception) {
            $this->exceptionHandler->handle($exception)->send();
        }
    }

    /**
     * @return Filter[]
     */
    public function filters()
    {
        return [];
    }

    /**
     * @param string  $method
     * @param Request $request
     *
     * @return Response
     * @throws Exception
     *
     */
    public function runMethod($method, Request $request)
    {
        if (!method_exists($this, $method)) {
            return new View('errors.404');
        }
        try {
            return $this->callMethod($method, $request);
        } catch (Exception $exception) {
            return $this->exceptionHandler->handle($exception);
        }
    }

    /**
     * @param $method
     * @param $request
     *
     * @return mixed
     */
    private function callMethod($method, Request $request)
    {
        return call_user_func([$this, $method], $request);
    }
}