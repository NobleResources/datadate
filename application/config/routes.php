<?php


$route = [
    '404_override' => '',
    'default_controller' => 'welcome',
    'translate_uri_dashes' => false,

    'signup' => [
        'post' => 'auth/signup/post',
        'get' => 'auth/signup/get',
    ]
];