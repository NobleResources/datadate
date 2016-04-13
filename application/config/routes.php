<?php


$route = [
    '404_override' => '',
    'default_controller' => 'welcome',
    'translate_uri_dashes' => false,

    'signup' => [
        'post' => 'Auth/SignUp/post',
        'get' => 'Auth/SignUp/get',
    ],

    'signin' => [
        'post' => 'Auth/SignIn/post',
        'get' => 'Auth/SignIn/get',
    ],

    'profile' => [
        'get' => 'Profile/get',
        'post' => 'Profile/post',
    ]

];