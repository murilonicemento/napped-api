<?php

namespace App\Models;

use App\Models\Model;

class User extends Model {
  public function register($name, $email, $password) {
    try {
      if ($this->userExist($email)) return false;

      $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

      $stmt = $this->connection->prepare($query);

      $stmt->bindValue(":name", $name);
      $stmt->bindValue(":email", $email);
      $stmt->bindValue(":password", $password);

      $stmt->execute();

      return $this->getUser($email);
    } catch (\Exception $exception) {
      return $exception->getMessage();
    }
  }

  private function userExist($email) {
    $query = "SELECT id, name, email, password FROM users WHERE email = :email";

    $stmt = $this->connection->prepare($query);
    $stmt->bindValue(":email", $email);

    $stmt->execute();

    return empty($stmt->fetchAll(\PDO::FETCH_ASSOC)) ? false : true;
  }

  private function getUser($email) {
    $query = "SELECT id, name, email, password FROM users WHERE email = :email";

    $stmt = $this->connection->prepare($query);
    $stmt->bindValue(":email", $email);

    $stmt->execute();

    $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    $user["statusCode"] = 200;

    return $user;
  }
}
