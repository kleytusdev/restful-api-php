<?php

namespace App\Controllers\Auth;

use Database\Database;
use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use PDO;

class AuthenticatedController
{
  public function __construct()
  {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
    $dotenv->load();
  }

  public function store()
  {
    $data = json_decode(file_get_contents("php://input"), true);

    $query = "SELECT * FROM users WHERE email = :email AND password = :password";
    $statement = Database::getConnection()->prepare($query);
    $statement->bindParam(":email", $data['email']);
    $statement->bindParam(":password", $data['password']);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      $now = strtotime('now');
      $key = $_ENV['API_SECRET_KEY'];
      $payload = [
        'exp' => $now + 3600,
        'data' => [
          'user_id' => $user['id'],
        ],
      ];

      $token = JWT::encode($payload, $key, 'HS256');

      die(json_encode(['token' => $token]));
    } else {
      http_response_code(401);
      die(json_encode(['message' => 'Usuario incorrecto.']));
    }
  }
}
