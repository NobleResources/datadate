<?php

function str_random($numChars)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $string = '';
    for ($i = 0; $i < $numChars; $i++) {
        $string .= $characters[rand(0, $charactersLength - 1)];
    }
    return $string;
}