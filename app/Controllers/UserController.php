<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
  public static function registerUser($email, $name, $password) {
    try {
      $user = new User();

      $newUser = $user->register($email, $name, password_hash($password, PASSWORD_DEFAULT));

      if (!$newUser) return ["error" => "Usuário já cadastrado", "statusCode" => 400];

      return $newUser;
    } catch (\Exception $exception) {
      return $exception->getMessage();
    }
  }
}
