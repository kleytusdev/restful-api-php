<?php

namespace App\Core;

use PDO;
use Exception;
use PDOException;
use Database\Database;

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
  public static function all(): void
  {
    $statement = Database::getConnection()->query('SELECT * FROM ' . static::$table);

    echo json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
  }

  /**
   * Crea un nuevo registro en la base de datos a partir de un array asociativo.
   *
   * @param array $data Array asociativo con las columnas y valores del nuevo registro.
   * @throws Exception Si se produce un error al crear el registro.
   * @return mixed El registro creado, o `null` si no se pudo crear.
   */
  public static function create(array $data)
  {
    // Obtiene las columnas de la tabla para validar los datos.
    $columns = static::getColumns();

    /**
     * Filtrar columnas no válidas de $data con array_filter
     * y la constante ARRAY_FILTER_USE_KEY para conservar las claves de $data
     * en el nuevo array $filteredData a partir de las claves de $columns.
     */
    $filteredData = array_filter($data, fn ($key) => in_array($key, $columns), ARRAY_FILTER_USE_KEY);

    // Validar si hay columnas no válidas en $data
    $invalidColumns = array_diff_key($data, $filteredData);
    if (!empty($invalidColumns)) throw new Exception("Las siguientes columnas no son válidas: " . implode(', ', array_keys($invalidColumns)));

    try {
      // Prepara la consulta INSERT con los datos filtrados.
      $query = static::buildInsertQuery($filteredData);
      $statement = Database::getConnection()->prepare($query);
      $statement->execute($filteredData);

      // Obtener el ID autogenerado
      $resourceId = Database::getConnection()->lastInsertId();

      return static::find($resourceId);
    } catch (PDOException $e) {
      throw new Exception("No se pudo crear el recurso: " . $e->getMessage());
    }
  }

  /**
   * Busca un registro en la base de datos por su ID y lo muestra en formato JSON.
   *
   * @param int $id ID del registro a buscar.
   * @throws Exception Si se produce un error al ejecutar la consulta.
   * @return void
   */
  public static function find(int $id): void
  {
    try {
      $query = 'SELECT * FROM ' . static::$table . ' WHERE id = ' . $id;
      $statement = Database::getConnection()->prepare($query);
      $statement->execute();

      echo json_encode($statement->fetch(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
      throw new Exception("No se pudo encontrar el registro: " . $e->getMessage());
    }
  }

  /**
   * Busca registros en la base de datos basados en una columna, operador y valor.
   *
   * @param string $column Nombre de la columna de la tabla para la condición WHERE.
   * @param string $operator Operador lógico para la condición WHERE. Admite los siguientes valores: =, <, >, <=, >=, !=, LIKE.
   * @param mixed $value Valor a comparar en la condición WHERE.
   *
   * @throws Exception Si se usa un operador no permitido.
   *
   * @return void (imprime el resultado codificado en JSON)
   */
  public static function where(string $column, string $operator, mixed $value): void
  {
    // Validar operadores permitidos (opcional)
    $allowedOperators = ['=', '<', '>', '<=', '>=', '!=', 'LIKE'];

    if (!in_array($operator, $allowedOperators)) {
      throw new Exception("Operador no válido: {$operator}");
    }

    $statement = Database::getConnection()->query('SELECT * FROM ' . static::$table . ' WHERE ' . $column . ' ' . $operator . ' ' . $value);

    echo json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
  }

  /**
   * Obtiene las columnas de la tabla del modelo actual.
   *
   * @return array Lista de nombres de las columnas.
   */
  private static function getColumns(): array
  {
    try {
      $sql = Database::getConnection()->prepare('DESCRIBE ' . static::$table);
      $sql->execute();
      return array_column($sql->fetchAll(PDO::FETCH_ASSOC), 'Field');
    } catch (PDOException $e) {
      throw new Exception("No se pudieron recuperar las columnas de la tabla: " . $e->getMessage());
    }
  }

  /**
   * Construye una consulta INSERT a partir de un array de datos.
   *
   * @param array $data Array asociativo con las columnas y valores del nuevo registro.
   *
   * @return string Consulta INSERT formateada.
   */
  private static function buildInsertQuery(array $data): string
  {
    $columns = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));

    return sprintf(
      'INSERT INTO %s (%s) VALUES (%s)',
      static::$table,
      $columns,
      $placeholders
    );
  }
}
