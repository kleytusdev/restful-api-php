<?php

namespace App\Models;

use PDO;
use PDOException;
use Database\Database;

class Product
{
  public static function getAll(): array
  {
    $query = "SELECT * FROM products";

    try {
      $result = Database::getConnection()->query($query);
      return $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return ["error" => "Error fetching products {$e->getMessage()}"];
    }
  }
}
