<?php

use App\Controllers\AuthenticatedController;
use App\Core\Route;
use App\Core\RouteCollection;
use App\Controllers\ProductController;
use App\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Rutas API
|--------------------------------------------------------------------------
|
| Aquí es donde se registran las rutas API de la aplicación.
|
*/

$routes = new RouteCollection();

$routes->addRoute(Route::post('/auth', [AuthenticatedController::class, 'store']));

$routes->addRoute(Route::get('/products', [ProductController::class, 'index']));
$routes->addRoute(Route::post('/products', [ProductController::class, 'store']));

$routes->addRoute(Route::get('/categories', [CategoryController::class, 'index']));
$routes->addRoute(Route::post('/categories', [CategoryController::class, 'store']));

return $routes;