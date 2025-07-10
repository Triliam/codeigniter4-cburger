<?php

namespace app\Routes;

use App\Controllers\ProductsController;
use Config\Services;

$routes = Services::routes();

//cburger back routes

//main
$routes->get('/', 'MainController::index');

//login e logout
$routes->get('/auth/login', 'AuthController::login');
$routes->post('/auth/submit', 'AuthController::submit');
$routes->get('/auth/logout', 'AuthController::logout');

//products
$routes->get('/products', 'ProductsController::index');
$routes->get('/products/new', 'ProductsController::newProduct');
$routes->post('products/prodsubmit', 'ProductsController::submitProduct' );

//edit products
$routes->get('/products/edit/(:alphanum)', 'ProductsController::edit/$1');
$routes->post('/products/edit_submit', 'ProductsController::edit_submit');

//delete product
$routes->get('/products/delete/(:alphanum)', 'ProductsController::delete/$1');
$routes->get('/products/delete_confirm/(:alphanum)', 'ProductsController::delete_confirm/$1');

//stock
$routes->get('stocks/product/(:alphanum)',  'StocksController::stock/$1');
