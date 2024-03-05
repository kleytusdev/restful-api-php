<?php

namespace App\Core;

use PDO;
use Database\Database;
use App\Utils\ValidateHttpMethod;

/**
 * Clase base para modelos que representan entidades en la base de datos.
 * Puede ser extendida para implementar funcionalidades específicas.
 */
class Model
{

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
    $statement = Database::getConnection()->query('SELECT * FROM ' . static::$table);

    return json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
  }

  public static function add()
  {
    $sql = Database::getConnection()->prepare('DESCRIBE '. static::$table);

    $sql->execute();

    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    $columns = [];

    foreach ($resultado as $index => $row) {

      if ($index != 0) {

        $columns[] = $row['Field'];
      }
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data)) {
      return "INGRESE DATOS";
    }

    $columnnames = implode(', ', $columns);
    $variablecolumns = implode(', :', $columns);

    $query = 'INSERT INTO '. static::$table .' ('. $columnnames .') VALUES (:'.$variablecolumns.')';
    
    $statement = Database::getConnection()->prepare($query);

    foreach ($columns as $column) {
      $statement->bindValue(':'. $column, $data[$column]);
    }

    $statement->execute();

    return self::get();
  }
}
