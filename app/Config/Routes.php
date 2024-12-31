<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\User\UserController;
use App\Controllers\Dashboard\DashboardController;
use App\Controllers\User\GoogleLoginController;

// use App\Controllers\API\DeepWorkController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('register', [UserController::class, 'newUser']);
$routes->post('register', [UserController::class, 'createUser']);

$routes->get('login', [UserController::class, 'existingUser']);
$routes->post('login', [UserController::class, 'verifyUser']);

$routes->get('googleLogin', [GoogleLoginController::class, 'login']);
$routes->get('googleCallback', [GoogleLoginController::class, 'googleCallback']);

$routes->get('logout', [UserController::class, 'logout']);

$routes->get('board', [DashboardController::class, 'dashboard']);

$routes->resource('tasks', ['controller' => '\App\Controllers\API\DeepWorkController']);
// Equivalent to the following:
// [NOTA] $routes->get('photos/new', 'Photos::new');
// [DONE] $routes->post('photos', 'Photos::create');
// [DONE] $routes->get('photos', 'Photos::index');
// [DONE] $routes->get('photos/(:segment)', 'Photos::show/$1');
// [FORM] $routes->get('photos/(:segment)/edit', 'Photos::edit/$1');
// $routes->put('photos/(:segment)', 'Photos::update/$1');
// $routes->patch('photos/(:segment)', 'Photos::update/$1');
// $routes->delete('photos/(:segment)', 'Photos::delete/$1');
