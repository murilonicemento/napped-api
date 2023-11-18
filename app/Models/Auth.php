<?php

namespace App\Models;

use App\Models\Model;
use App\Models\User;

class Auth extends Model {
  public function register($name, $email, $password, $token) {
    try {
      $user = new User();

      if ($user->userExist($email)) return false;

      $query = "INSERT INTO napped.users (name, email, password, access_token) VALUES (:name, :email, :password, :access_token)";

      $stmt = $this->connection->prepare($query);

      $stmt->bindValue(":name", $name);
      $stmt->bindValue(":email", $email);
      $stmt->bindValue(":password", $password);
      $stmt->bindValue(":access_token", $token);

      $isRegistered = $stmt->execute();

      if ($isRegistered != 1) return false;

      return $user->getUser($email);
    } catch (\Exception $exception) {
      return $exception->getMessage();
    }
  }

  public function login($email) {
    try {
      $query = "SELECT id, name, email, password, access_token FROM users WHERE email = :email";

      $stmt = $this->connection->prepare($query);
      $stmt->bindValue(":email", $email);

      $stmt->execute();

      $user = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $user;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public function validateToken($id) {
    try {
      $query = "SELECT access_token FROM napped.users WHERE id = :id";

      $stmt = $this->connection->prepare($query);
      $stmt->bindValue(":id", $id);

      $stmt->execute();

      $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      $token = $data[0]["access_token"];

      return $token;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }
}
