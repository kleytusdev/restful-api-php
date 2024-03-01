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

    if (!$id) {
      return json_encode(["error" => "Falta el ID de categoría en la URL."]);
    }
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
      return json_encode(["error" => "ID de categoría no válida."]);
    }

    $requestData = json_decode(file_get_contents('php://input'), true);

    if (isset($requestData['name'])) {
      $newName = $requestData['name'];
    } else {
      return json_encode(["error" => "El campo 'name' es obligatorio en la solicitud."]);
    }

    try {
      $query = "UPDATE categories SET name = :newName WHERE id = :id";
      $stmt = Database::getConnection()->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':newName', $newName, PDO::PARAM_STR);
      $stmt->execute();

      return json_encode(['success' => 'Categoría actualizada.']);
    } catch (PDOException $e) {
      return json_encode(["error" => "Error al actualizar la categoría {$e->getMessage()}"]);
    }
  }
}
