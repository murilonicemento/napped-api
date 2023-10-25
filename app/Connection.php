<?php

namespace App;

class Connection {
  public static function DB() {
    try {
      $connection = new \PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']};charset=utf8", $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);

      return $connection;
    } catch (\PDOException $exception) {
      echo "Erro ao realizar conexão ao Banco de Dados";
    }
  }
}
