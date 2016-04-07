<?php

namespace DataDate\Http;

use DataDate\Database\Connection;
use DataDate\Database\Model;
use DataDate\Http\Request;
use DataDate\Http\Responses\Response;
use DataDate\Services\ExceptionHandler;
use DataDate\Services\Redirector;
use DataDate\Services\Validation\ValidationException;
use DataDate\Services\Validation\ValidationService;
use DataDate\Session;
use DataDate\Views\View;
use Exception;
use ReflectionParameter;

class Controller
{
    /**
     * @var ExceptionHandler
     */
    private $exceptionHandler;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ValidationService
     */
    protected $validator;
    /**
     * @var Redirector
     */
    protected $redirector;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $ciController = new \CI_Controller();

        $ciController->load->library('session');
        $ciController->load->model('user');

        $connection = new Connection($ciController->load->database('', true));
        Model::setConnection($connection);

        $this->session = new Session($ciController->session);
        $this->request = new Request($ciController->input);
        $this->validator = new ValidationService($connection);
        $this->redirector = new Redirector($this->session, $this->request);
        $this->exceptionHandler = new ExceptionHandler($this->redirector, $this->request);
    }

    /**
     * @param       $method
     * @param array $routeParameters
     *
     * @throws Exception
     */
    public function _remap($method, $routeParameters = [])
    {
        $this->sendResponse($this->getResponse($method, $routeParameters));
    }

    /**
     * @param       $method
     * @param array $routeParameters
     *
     * @return Response|View|mixed
     * @throws ValidationException
     */
    public function getResponse($method, $routeParameters = [])
    {
        if (!method_exists($this, $method)) {
            return new View('errors.404');
        }

        try {
            return $this->callMethod($method, $this->prepareParameters($method, $routeParameters));
        } catch (Exception $exception) {
            return $this->exceptionHandler->handle($exception);
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
     * @param $routeParameters
     *
     * @return mixed
     */
    private function prepareParameters($method, $routeParameters)
    {
        $parameters = $this->getParameters($method);

        foreach ($parameters as $index => $parameter) {
            $parameters[$index] = $this->prepareParameter($parameter, $routeParameters);
        }

        return $parameters;
    }

    /**
     * @param ReflectionParameter  $parameter
     * @param                      $routeParameters
     *
     * @return Request
     */
    private function prepareParameter(ReflectionParameter $parameter, &$routeParameters)
    {
        $class = $parameter->getClass();

        if ($class === null) {
            return array_shift($routeParameters);
        }

        $className = $class->getName();

        if ($className === Request::class) {
            return $this->request;
        }

        if ($className === Session::class) {
            return $this->session;
        }

        return null;
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

    /**
     * @param $method
     *
     * @return ReflectionParameter[]
     */
    private function getParameters($method)
    {
        $reflection = new \ReflectionMethod($this, $method);
        $parameters = $reflection->getParameters();
        return $parameters;
    }
}