<?php

namespace App\Core;

use App\Core\RouteCollection;

class Dispatcher
{
  public function __construct(
    private RouteCollection $routes
  ) {
  }

  public function dispatch()
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $url = $_SERVER['REQUEST_URI'];
    $script_name = $_SERVER['SCRIPT_NAME'];

    // Obtener la ruta sin "index.php"
    $path = str_replace($script_name, '', $url);

    $route = $this->routes->getRouteByUri($path);

    if (!$route) {
      return $this->echoResponse('Ruta no encontrada');
    }
    if ($method !== $route->getMethodHttp()) {
      return $this->echoResponse('Método HTTP no permitido');
    }

    $params = $this->routes->getParams($path, $route);

    $controllerClass = $route->getController();
    $controller = new $controllerClass();
    $controllerMethod = $route->getMethod();

    $controller->$controllerMethod(...$params);
  }

  private function echoResponse(string $message): void
  {
    header('Content-Type: text/plain');
    echo $message;
    exit();
  }
}

(new Dispatcher(require 'routes/api.php'))->dispatch();
