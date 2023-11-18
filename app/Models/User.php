<?php

namespace App\Models;

use App\Models\Model;

class User extends Model {
  public function update($id, $name, $email, $password) {
    try {
      $query = "UPDATE napped.users
      SET 
        name = CASE WHEN :name IS NOT NULL THEN :name ELSE name END,
        email = CASE WHEN :email IS NOT NULL THEN :email ELSE email END,
        password = CASE WHEN :password IS NOT NULL THEN :password ELSE password END
      WHERE id = :id";

      $stmt = $this->connection->prepare($query);

      $stmt->bindValue(":name", $name);
      $stmt->bindValue(":email", $email);
      $stmt->bindValue(":password", $password);
      $stmt->bindValue(":id", $id);

      return $stmt->execute();
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

  public function userExist($email) {
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

  public function getUser($email) {
    try {
      $query = "SELECT id, name, email FROM napped.users WHERE email = :email";

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
