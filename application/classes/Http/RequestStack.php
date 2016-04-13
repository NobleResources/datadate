<?php

namespace DataDate\Http;

use Closure;
use DataDate\Http\Filters\Filter;
use DataDate\Http\Responses\Response;

class RequestStack
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var callable
     */
    private $final;
    /**
     * @var Filter[]
     */
    private $filters;

    /**
     * RequestStack constructor
     *
     * @param Request  $request
     * @param callable $final
     * @param Filter[] $filters
     */
    public function __construct(Request $request, callable $final, $filters = [])
    {
        $this->request = $request;
        $this->filters = array_map([$this, 'filterToCallable'], $filters);
        $this->final = $final;
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $initial = $this->getInitial($this->final);

        return call_user_func(array_reduce(array_reverse($this->filters), $this->getNext(), $initial), $this->request);
    }

    /**
     * @return callable
     */
    private function filterToCallable($filter)
    {
        return [$filter, 'handle'];
    }

    /**
     * @param callable $final
     *
     * @return callable
     */
    private function getInitial(callable $final)
    {
        return function($request) use ($final) {
            return call_user_func($final, $request);
        };
    }

    /**
     * @return callable
     */
    private function getNext()
    {
        return function ($stack, $filter) {
            return function ($request) use ($stack, $filter) {
                return call_user_func($filter, $request, $stack);
            };
        };
    }
}