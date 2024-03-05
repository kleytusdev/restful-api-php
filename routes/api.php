<?php

namespace Routes;

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

$routes->addRoute(Route::get('/about', [ProductController::class, 'index']));
$routes->addRoute(Route::post('/create', [CategoryController::class,'create']));

return $routes;