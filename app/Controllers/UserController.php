<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
  public static function registerUser($email, $name, $password) {
    try {
      $user = new User();

      $newUser = ["user" => $user->register($email, $name, password_hash($password, PASSWORD_DEFAULT))];

      if (!$newUser["user"]) return ["error" => ["message" => "Usuário já cadastrado."], "statusCode" => 400];

      $newUser["message"] = "Usuário cadastrado com sucesso.";
      $newUser["statusCode"] = 201;

      return $newUser;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public static function loginUser($email, $password) {
    try {
      $user = new User();
      $data = ["user" => $user->login($email)];

      if (!$data["user"]) return ["error" => ["message" => "Usuário não cadastrado ou credenciais incorretas."], "statusCode" => 400];

      if (!password_verify($password, $data["user"]["password"])) return ["error" => ["message" => "Usuário ou senha inválidos. Verifique suas credenciais."], "statusCode" => 401];

      $data["message"] = "Login bem-sucedido.";
      $data["statusCode"] = 200;

      return $data;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public static function updateUser($id) {
    try {
      $user = new User();
      $data = $user->update($id);

      $data["message"] = "Atualização bem-sucedida.";
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

      return $data > 0 ? ["message" => "Usuário deletado com sucesso.", "statusCode" => 200] : ["error" => ["message" => "Usuário já foi deletado."], "statusCode" => 400];
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }
}
