<?php

namespace Database;

use PDO;
use Dotenv\Dotenv;

class Database
{
  private static $connection;

  private static function getCredentials(): array
  {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    return [
      'host'     => $_ENV['DB_HOST'],
      'database' => $_ENV['DB_DATABASE'],
      'username' => $_ENV['DB_USERNAME'],
      'password' => $_ENV['DB_PASSWORD'],
    ];
  }

  public static function getConnection(): PDO
  {
    if (!self::$connection) {
      $config = self::getCredentials();
      self::$connection = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']}",
        $config['username'],
        $config['password']
      );
    }

    return self::$connection;
  }
}
