<?php

namespace App\Core;

use App\Utils\ValidateHttpMethod;
use PDO;
use Database\Database;

/**
 * Clase base para modelos que representan entidades en la base de datos.
 * Puede ser extendida para implementar funcionalidades específicas.
 */
class Model
{
  private const HTTP_METHOD_GET = "GET";

  /**
   * @var int $id Identificador único de la entidad del modelo.
   */
  protected int $id;

  /**
   * @var string $table Nombre de la tabla de la base de datos asociada al modelo.
   */
  protected static string $table;

  /**
   * Retorna todas las filas de la tabla asociada al modelo en formato JSON.
   *
   * @return string Representación JSON de todas las filas de la tabla.
   */
  public static function get(): string
  {
    ValidateHttpMethod::validateHttpMethod(self::HTTP_METHOD_GET);

    $statement = Database::getConnection()->query('SELECT * FROM ' . static::$table);

    return json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
  }
}
