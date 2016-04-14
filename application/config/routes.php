<?php


$route = [
    '404_override' => '',
    'default_controller' => 'Site',
    'translate_uri_dashes' => false,

    'signup' => [
        'post' => 'Authentication/signUp',
        'get' => 'Authentication/signUpForm',
    ],

    'signin' => [
        'post' => 'Authentication/signIn',
        'get' => 'Authentication/signInForm',
    ],

    'signout' => 'Authentication/signOut',

    'profile' => [
        'get' => 'Profile/get',
        'post' => 'Profile/post',
    ]

];