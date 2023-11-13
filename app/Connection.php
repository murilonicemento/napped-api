<?php

namespace App;

abstract class Connection {
  public function DB() {
    try {
      $options_pdo = [
        \PDO::ATTR_ERRMODE =>  \PDO::ERRMODE_EXCEPTION
      ];

      $connection = new \PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']};charset=utf8", $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $options_pdo);

      return $connection;
    } catch (\PDOException $exception) {
      throw $exception;
    }
  }
}
