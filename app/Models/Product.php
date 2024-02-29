<?php

namespace App\Models;

use PDO;
use PDOException;
use Database\Database;

class Product
{
  public static function getAll(): string
  {
    $query = "SELECT * FROM products";

    try {
      $result = Database::getConnection()->query($query);
      return json_encode($result->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
      return json_encode(["error" => "Error fetching products {$e->getMessage()}"]);
    }
  }
}
