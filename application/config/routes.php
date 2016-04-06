<?php

$route['404_override'] = '';
$route['default_controller'] = 'welcome';
$route['translate_uri_dashes'] = FALSE;

$route['signup'] = [
    'POST' => 'auth/signup/post',
    'GET' => 'auth/signup/get',
];