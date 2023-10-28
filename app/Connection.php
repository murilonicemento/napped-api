<?php

namespace App;

abstract class Connection {
  public function DB() {
    try {
      $connection = new \PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']};charset=utf8", $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);

      return $connection;
    } catch (\PDOException $exception) {
      throw $exception;
    }
  }
}
