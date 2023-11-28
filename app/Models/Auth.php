<?php

namespace App\Models;

use App\Models\Model;

class Auth extends Model {
  public function register($name, $email, $password) {
    try {
      if ($this->userExist($email)) return false;

      $query = "INSERT INTO napped.users (name, email, password) VALUES (:name, :email, :password)";

      $stmt = $this->connection->prepare($query);

      $stmt->bindValue(":name", $name);
      $stmt->bindValue(":email", $email);
      $stmt->bindValue(":password", $password);

      $isRegistered = $stmt->execute();

      if ($isRegistered != 1) return false;

      return $this->getUser($email);
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

  public function updateToken($email, $token) {
    try {
      $query = "UPDATE napped.users SET access_token = :access_token WHERE email = :email";

      $stmt = $this->connection->prepare($query);
      $stmt->bindValue(":access_token", $token);
      $stmt->bindValue(":email", $email);

      $stmt->execute();

      return $this->getUser($email);
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public function validateToken($token) {
    try {
      $query = "SELECT id, name, email, password, access_token FROM napped.users WHERE access_token = :access_token";

      $stmt = $this->connection->prepare($query);
      $stmt->bindValue(":access_token", $token);

      $stmt->execute();

      $data = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $data;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  private function userExist($email) {
    try {
      $query = "SELECT id, name, email FROM napped.users WHERE email = :email";

      $stmt = $this->connection->prepare($query);
      $stmt->bindValue(":email", $email);

      $stmt->execute();

      return empty($stmt->fetchAll(\PDO::FETCH_ASSOC)) ? false : true;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  private function getUser($email) {
    try {
      $query = "SELECT id, name, email, password, access_token FROM napped.users WHERE email = :email";

      $stmt = $this->connection->prepare($query);
      $stmt->bindValue(":email", $email);

      $stmt->execute();

      $user = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $user;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }
}
