<?php

namespace App\Utils;

class ValidateHttpMethod
{
  public static function validateHttpMethod(string $httpMethod): void
  {
    if ($_SERVER['REQUEST_METHOD'] !== $httpMethod) {
      http_response_code(405);
      echo json_encode(["error" => "Método de solicitud no permitido."]);
      exit();
    }
  }
}