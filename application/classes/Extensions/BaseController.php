<?php

namespace DataDate\Extensions;

use DataDate\Http\Request;
use DataDate\Http\Responses\Response;
use DataDate\Services\ExceptionHandler;
use DataDate\Services\Redirector;
use DataDate\Services\Validation\ValidationService;
use DataDate\Session;
use DataDate\Views\View;

class BaseController extends \CI_Controller
{
    /**
     * @var ExceptionHandler
     */
    private $exceptionHandler;
    /**
     * @var ValidationService
     */
    protected $validator;
    /**
     * @var Redirector
     */
    protected $redirector;
    /**
     * @var Session
     */
    public $session;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->session = Session::load();
        $request = Request::load();

        $this->exceptionHandler = new ExceptionHandler();
        $this->redirector = new Redirector($this->session, $request);
        $this->validator = new ValidationService();
    }

    /**
     * @param       $method
     * @param array $parameters
     *
     * @throws \Exception
     */
    public function _remap($method, $parameters = [])
    {
        if ( ! method_exists($this, $method)) {
            $this->sendResponse(new View('errors.404'));
        }

        try {
            $response = $this->callMethod($method, $this->prepareParameters($method, $parameters));
            $this->sendResponse($response);

        } catch (\Exception $e) {
            $this->exceptionHandler->handle($e);
        }
    }

    /**
     * @param mixed $response
     */
    private function sendResponse($response)
    {
        $response = $this->makeResponse($response);
        $response->send();
    }

    /**
     * @param mixed $response
     *
     * @return Response
     */
    private function makeResponse($response)
    {
        if ($response instanceof Response) {
            return $response;
        }

        if ($response instanceof View) {
            $content = $response->render();
            return new Response($content, 200);
        }

        return new Response($response, 200);
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    private function prepareParameters($method, $parameters)
    {
        $reflection = new \ReflectionMethod($this, $method);
        $ps = $reflection->getParameters();
        foreach ($ps as $p) {
            if ($p->getClass()->getName() === Request::class) {
                $parameters[$p->getPosition()] = Request::load();
            }
        }
        return $parameters;
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    private function callMethod($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }
}