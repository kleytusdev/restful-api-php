<?php

namespace App\Core;

class RouteCollection
{
  private array $routes;

  public function addRoute(Route $route)
  {
    $this->routes[] = $route;
  }

  public function getRoutes(): array
  {
    return $this->routes;
  }

  public function getParams(string $uri, Route $route){
    $route_uri = $route->getUri();

        if(strpos($route_uri, '{') !== false){
          $route_uri = preg_replace('#{[a-zA-Z]+}#', '([a-zA-Z0-9])', $route_uri);
        }
        

        if (preg_match("#^$route_uri$#", $uri, $matches)) {
          $params = array_slice($matches, 1);

          return $params;
        }
  }

  public function getRouteByUri(string $uri): ?Route
  {
    foreach ($this->routes as $route) {
        $route_uri = $route->getUri();

        if(strpos($route_uri, '{') !== false){
          $route_uri = preg_replace('#{[a-zA-Z]+}#', '([a-zA-Z0-9])', $route_uri);
        }
        

        if (preg_match("#^$route_uri$#", $uri)) {

          return $route;
        }
    }

    return null;
  }
}
