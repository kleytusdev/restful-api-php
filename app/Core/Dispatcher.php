<?php

namespace App\Core;

use App\Core\Route;
use App\Core\RouteCollection;

class Dispatcher
{
  public function dispatch()
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $url = $_SERVER['REQUEST_URI'];

    $routes = require 'routes/api.php';

    $route = $routes->getRouteByUri($url);

    if (!$route) {
      echo "Ruta no encontrada";
      return;
    }

    if ($method !== $route->getMethodHttp()) {
      echo "Método HTTP no permitido";
      return;
    }

    $controllerClassName = $route->getController();

    $controller = new $controllerClassName();
    $method = $route->getMethod();

    $controller->$method();
  }
}

$dispatcher = new Dispatcher();
$dispatcher->dispatch();
