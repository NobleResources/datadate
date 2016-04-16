<?php

function array_first(array $array)
{
    if (isset($array[0])) {
        return $array[0];
    }

    return null;
}

function array_last(array $array)
{
    if (empty($array)) {
        return null;
    }

    return $array[count($array) - 1];
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
    $keys = is_array($keys) ? $keys : [$keys];

    foreach ($array as $key => $value) {
        if (array_search($key, $keys) === false) {
            unset ($array[$key]);
        }
    }

    return $array;
}

function array_prepend(&$array, $item) {
    $array = array_merge([$item], $array);
}