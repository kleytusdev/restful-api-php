<?php

namespace App\Core;

class RouteCollection
{
  private $routes = [];

  public function addRoute(Route $route)
  {
    $this->routes[] = $route;
  }

  public function getRoutes(): array
  {
    return $this->routes;
  }

  public function getRouteByUri(string $uri): ?Route
  {
    foreach ($this->routes as $route) {
      if ($route->getUri() === $uri) {
        return $route;
      }
    }

    return null;
  }
}
