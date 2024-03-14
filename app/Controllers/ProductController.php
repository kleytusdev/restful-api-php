<?php

namespace App\Controllers;

use Dotenv\Dotenv;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use App\Models\Product;
use App\Models\Category;

class ProductController
{
  public function __construct()
  {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
  }

  public function getToken()
  {
    $headers = apache_request_headers();

    $authorization = $headers['Authorization'] ?? die(json_encode([
      'message' => 'Unauthenticated',
      'status' => 'error'
    ]));

    $authorizationArray = explode(' ', $authorization);
    $token = $authorizationArray[1];

    try {
      $decodedToken = JWT::decode($token, new Key($_ENV['API_SECRET_KEY'], 'HS256'));
    } catch (\Throwable $th) {
      http_response_code(500);
      die(json_encode([
        'message' => $th->getMessage(),
        'status' => 'error'
      ]));
    }

    return $decodedToken;
  }

  public function index()
  {
    $this->getToken();

    return Product::all();
  }

  public function store()
  {
    return Product::create([
      'name' => 'Product 1',
      'description' => 'Product description',
      'price' => 10,
      'stock' => 20,
      'category_id' => 1,
      'supplier_id' => 1,
    ]);
  }
}
