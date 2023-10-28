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

  public function login($email) {
    try {
      $query = "SELECT id, name, email, password FROM users WHERE email = :email";

      $stmt = $this->connection->prepare($query);
      $stmt->bindValue(":email", $email);

      $stmt->execute();

      $user = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $user;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public function delete($id) {
    try {
      $query = "DELETE FROM users WHERE id = :id";

      $stmt = $this->connection->prepare($query);
      $stmt->bindValue(":id", $id);

      $stmt->execute();

      return $stmt;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  private function userExist($email) {
    try {
      $query = "SELECT id, name, email, password FROM users WHERE email = :email";

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
      $query = "SELECT id, name, email, password FROM users WHERE email = :email";

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
