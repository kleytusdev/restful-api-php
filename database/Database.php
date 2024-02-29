<?php

namespace Database;

use PDO;

class Database
{
  private static $connection;

  private static function getCredentials(): array
  {
    return [
      'host' => getenv('DB_HOST'),
      'database' => getenv('DB_DATABASE'),
      'username' => getenv('DB_USERNAME'),
      'password' => getenv('DB_PASSWORD'),
    ];
  }

  public static function getConnection(): PDO
  {
    if (!self::$connection) {
      $config = self::getCredentials();
      var_dump($config);
      self::$connection = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']}",
        $config['username'],
        $config['password']
      );
    }

    return self::$connection;
  }
}
