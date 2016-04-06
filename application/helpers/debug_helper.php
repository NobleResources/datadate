<?php

function dump($variable)
{
    ob_start();
    var_dump($variable);
    $ci =& get_instance();

    return $ci->output->append_output(ob_get_clean());
}