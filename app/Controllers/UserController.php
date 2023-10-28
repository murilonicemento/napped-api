<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
  public static function registerUser($email, $name, $password) {
    try {
      $user = new User();

      $newUser = $user->register($email, $name, password_hash($password, PASSWORD_DEFAULT));

      if (!$newUser) return ["error" => "Usuário já cadastrado.", "statusCode" => 400];

      $newUser["statusCode"] = 200;

      return $newUser;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public static function loginUser($email, $password) {
    try {
      $user = new User();
      $data = $user->login($email);

      if (!password_verify($password, $data["password"])) return ["error" => "Usuário ou senha inválidos.", "statusCode" => 400];

      if (!$data) return ["error" => "Usuário não cadastrado.", "statusCode" => 400];

      $data["statusCode"] = 200;

      return $data;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public static function deleteUser($id) {
    try {
      $user = new User();
      $data = $user->delete($id);

      return $data ? ["message" => "Usuário deletado com sucesso."] : ["message" => "Erro ao tentar deletar usuário."];
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }
}
