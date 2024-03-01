<?php

namespace App\Models;

use PDO;
use PDOException;
use Database\Database;
use App\Utils\ValidateHttpMethod;

class Product
{
  private const HTTP_METHOD_GET = "GET";

  public static function getAll(): string
  {
    ValidateHttpMethod::validateHttpMethod(self::HTTP_METHOD_GET);

    try {
      $query = "SELECT * FROM products";
      $result = Database::getConnection()->query($query);

      return json_encode($result->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
      return json_encode(["error" => "Error fetching products {$e->getMessage()}"]);
    }
  }
}
