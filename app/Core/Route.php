<?php

namespace App\Core;

class Route
{
  public function __construct(
    private string $uri,
    private string $controller,
    private string $method,
    private string $methodHttp,
  ) {
  }

  public function getUri(): string
  {
    return $this->uri;
  }

  public function getController(): string
  {
    return $this->controller;
  }

  public function getMethod(): string
  {
    return $this->method;
  }

  public function getMethodHttp(): string
  {
    return $this->methodHttp;
  }

  public static function get(string $uri, $action)
  {
    if (is_callable($action)) {
      return new Route($uri, $action[0], $action[1], 'GET');
    } else {
      return new Route($uri, $action[0], $action[1], 'GET');
    }
  }
}
