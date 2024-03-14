<?php

use App\Core\Route;
use App\Core\RouteCollection;
use App\Controllers\UserController;
use App\Controllers\ProductController;
use App\Controllers\CategoryController;
use App\Controllers\Auth\AuthenticatedController;

/*
|--------------------------------------------------------------------------
| Rutas API
|--------------------------------------------------------------------------
|
| Aquí es donde se registran las rutas API de la aplicación.
|
*/

$routes = new RouteCollection();

$routes->addRoute(Route::post('/login', [AuthenticatedController::class, 'store']));

$routes->addRoute(Route::post('/users', [UserController::class, 'store']));

$routes->addRoute(Route::get('/products', [ProductController::class, 'index']));
$routes->addRoute(Route::post('/products', [ProductController::class, 'store']));

$routes->addRoute(Route::get('/categories', [CategoryController::class, 'index']));
$routes->addRoute(Route::post('/categories', [CategoryController::class, 'store']));

return $routes;