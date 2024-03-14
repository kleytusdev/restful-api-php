<?php

namespace App\Controllers;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Product;

class AuthenticatedController
{
  public function __construct(
  ) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
  }

  public function store()
  {
    $now = strtotime('now');
    $key = $_ENV['API_SECRET_KEY'];
    $payload = [
      'exp' => $now + 3600,
      'data' => 1,
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');
    $array = ["token" => $jwt];

    print_r($array);
  }
}
