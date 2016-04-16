<?php


$route = [
    '404_override' => '',
    'default_controller' => 'SiteController',
    'translate_uri_dashes' => false,

    'signup' => [
        'post' => 'AuthController/signUp',
        'get' => 'AuthController/signUpForm',
    ],

    'signin' => [
        'post' => 'AuthController/signIn',
        'get' => 'AuthController/signInForm',
    ],

    'signout' => 'AuthController/signOut',

    'profile' => [
        'get' => 'ProfileController/get',
        'post' => 'ProfileController/post',
    ],

    'users/(:num)' => 'UserController/show/$1',
    'users/(:num)/picture' => 'UserController/picture/$1',

];