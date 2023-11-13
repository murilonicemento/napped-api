<?php

namespace App\Models;

use App\Models\Model;

class User extends Model {
  public function register($name, $email, $password, $token) {
    try {
      if ($this->userExist($email)) return false;

      $query = "INSERT INTO napped.users (name, email, password, access_token) VALUES (:name, :email, :password, :access_token)";

      $stmt = $this->connection->prepare($query);

      $stmt->bindValue(":name", $name);
      $stmt->bindValue(":email", $email);
      $stmt->bindValue(":password", $password);
      $stmt->bindValue(":access_token", $token);

      $isRegistered = $stmt->execute();

      if ($isRegistered != 1) return false;

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

  public function update($id) {
    try {
      $query = "UPDATE";

      $stmt = $this->connection->prepare($query);
      $stmt->bindValue(":id", $id);

      $stmt->execute();
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
      return $stmt->rowCount();
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public function validateToken($email) {
    try {
      $query = "SELECT access_token FROM napped.users WHERE email = :email";

      $stmt = $this->connection->prepare($query);
      $stmt->bindValue(":email", $email);

      $stmt->execute();

      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
      $query = "SELECT id, name, email, access_token FROM napped.users WHERE email = :email";

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
