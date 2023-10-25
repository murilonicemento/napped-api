<?php

namespace App\Models;

use App\Connection;

class User {
  public function register($name, $email, $password) {
    try {
      if ($this->userExist($email)) return false;

      $connection = Connection::DB();

      $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

      $stmt = $connection->prepare($query);

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
    $connection = Connection::DB();

    $query = "SELECT id, name, email, password FROM users WHERE email = :email";

    $stmt = $connection->prepare($query);
    $stmt->bindValue(":email", $email);

    $stmt->execute();

    return empty($stmt->fetchAll(\PDO::FETCH_ASSOC)) ? false : true;
  }

  private function getUser($email) {
    $connection = Connection::DB();

    $query = "SELECT id, name, email, password FROM users WHERE email = :email";

    $stmt = $connection->prepare($query);
    $stmt->bindValue(":email", $email);

    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }
}
