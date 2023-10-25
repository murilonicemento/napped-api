<?php

namespace App\Models;

use App\Connection;

class User {
  public function getUser() {
    $connection = Connection::DB();

    $query = "SELECT * FROM users";

    $stmt = $connection->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
