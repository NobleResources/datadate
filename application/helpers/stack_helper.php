<?php


function destination($request)
{
    echo 'I got a ' . $request;
}

function run()
{
    $initial = getInitial('destination');

    $stack = [
        function ($request, callable $next) {
            echo 'One ';
            $next($request);
        },

        function ($request, callable $next) {
            echo 'Two ';
            $next($request);
        },

        function ($request, callable $next) {
            echo 'Three ';
            $next($request);

        },

        function ($request, callable $next) {
            echo 'Four ';
            $next($request);
        },

        function ($request, callable $next) {
            echo 'Five ';
            $next($request);

        }
    ];

    echo call_user_func(array_reduce(array_reverse($stack), getSlice(), $initial), 'A request');
}

function getSlice()
{
    return function ($stack, $filter) {
        return function ($request) use ($stack, $filter) {
            return call_user_func($filter, $request, $stack);
        };
    };
}

function getInitial(callable $destination)
{
    return function($request) use ($destination) {
        return call_user_func($destination, $request);
    };
}