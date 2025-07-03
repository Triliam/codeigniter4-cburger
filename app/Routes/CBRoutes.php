<?php

namespace app\Routes;
use Config\Services;

$routes = Services::routes();

//cburger back routes

//main
$routes->get('/', 'MainController::index');

//login e logout
$routes->get('/auth/login', 'AuthController::login');
$routes->post('/auth/submit', 'AuthController::submit');
$routes->get('/auth/logout', 'AuthController::logout');