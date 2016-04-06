<?php

function array_first(array $array)
{
    if (isset($array[0])) {
        return $array[0];
    }

    return null;
}

function array_except(array $array, $except)
{
    return array_filter($array, function ($key) use ($except) {
        return ! array_search($key, $except);
    }, ARRAY_FILTER_USE_KEY);
}