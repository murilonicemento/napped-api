<?php

namespace App\Models;

use App\Dependencies\Dependencies;

class User {
  public function getUser() {
    $connection = Dependencies::connection();

    $query = "SELECT * FROM users";

    $stmt = $connection->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
