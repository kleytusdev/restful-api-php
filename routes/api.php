<?php

use App\Core\Route;
use App\Core\RouteCollection;
use App\Controllers\ProductController;
use App\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Rutas API
|--------------------------------------------------------------------------
|
| Aquí es donde se registran las rutas API de la aplicación.
|
*/

$routes = new RouteCollection();

$routes->addRoute(Route::get('/about', [UserController::class, 'getall']));
$routes->addRoute(Route::post('/create',[UserController::class, 'add']));
$routes->addRoute(Route::get('/filtrado', [UserController::class, 'getById']));
$routes->addRoute(Route::delete('/category', [UserController::class, 'delete']));

return $routes;