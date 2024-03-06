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

  /**
   * 
   * @method static Esta funcion crea un nuevo registro en la base de datos de un modelo.
   * 
   * @param array $validData recibe un array asociativo con las columnas y valores de la tabla
   * 
   */
  public static function create(array $validData)
  {
    $sql = Database::getConnection()->prepare('DESCRIBE '. static::$table);

    $sql->execute();

    $dataColumns = $sql->fetchAll(PDO::FETCH_ASSOC);

    $columns = [];

    foreach ($dataColumns as $index => $row) {

      if ($index != 0) {

        $columns[] = $row['Field'];
      }
    }

    foreach($validData as $column => $value){

      if (!in_array($column, $columns)){
        return "Error el campo $column no existe";
      }

    }

    
    $columnnames = implode(', ', $columns);
    $variablecolumns = implode(', :', $columns);

    $query = 'INSERT INTO '. static::$table .' ('. $columnnames .') VALUES (:'.$variablecolumns.')';
    
    $statement = Database::getConnection()->prepare($query);

    foreach ($columns as $column) {
      $statement->bindValue(':'. $column, $validData[$column]);
    }

    $statement->execute();

    return self::get();
  }

  public static function where(string $column, $value, string $operador){

    if(!is_numeric($value)){
      $value = "'".$value."'";
    }

    $statement = Database::getConnection()->query('SELECT * FROM ' . static::$table .' WHERE '.$column.' '.$operador.' '.$value);

    return json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
  }
}
