<?php

function array_first(array $array)
{
    if (isset($array[0])) {
        return $array[0];
    }

    return null;
}

function array_except($array, $except)
{
    $except = is_array($except) ? $except : [$except];

    foreach ($array as $key => $value) {
        if (array_search($key, $except) !== false) {
            unset ($array[$key]);
        }
    }

    return $array;
}

function array_only($array, $keys)
{
    return array_filter($array, function ($key) use ($keys) {
        return array_key_exists($key, $keys);
    }, ARRAY_FILTER_USE_KEY);
}

function array_prepend(&$array, $item) {
    $array = array_merge([$item], $array);
}