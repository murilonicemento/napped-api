<?php

namespace App\Models;

use App\Connection;

class Model extends Connection {
  protected $connection;

  public function __construct() {
    $this->connection = $this->DB();
  }
}
