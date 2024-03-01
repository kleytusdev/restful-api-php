<?php

namespace App\Models;

use PDO;
use PDOException;
use Database\Database;
use App\Utils\ValidateHttpMethod;

class Category
{
  private const HTTP_METHOD_PATCH = "PATCH";

  public static function update(): string
  {
    ValidateHttpMethod::validateHttpMethod(self::HTTP_METHOD_PATCH);

    $id = explode('/', $_SERVER['REQUEST_URI'])[2];

    if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
      return json_encode(["error" => "ID de categoría no válido o faltante."]);
    }

    $requestData = json_decode(file_get_contents('php://input'), true);

    if (!isset($requestData['name']) || !preg_match('/^[a-zA-Z]+$/', $requestData['name'])) {
      return json_encode(["error" => "El campo 'name' debe contener solo letras."]);
    }

    try {
      $query = "UPDATE categories SET name = :name WHERE id = :id";
      $statement = Database::getConnection()->prepare($query);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->bindParam(':name', $requestData['name'], PDO::PARAM_STR);
      $statement->execute();

      return json_encode(['success' => 'Categoría actualizada.']);
    } catch (PDOException $e) {
      return json_encode(["error" => "Error al actualizar la categoría {$e->getMessage()}"]);
    }
  }
}
