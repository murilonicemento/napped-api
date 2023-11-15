<?php

namespace App\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;

class UserController {
  public static function registerUser($email, $name, $password) {
    try {
      $user = new User();

      $token = self::generateToken();

      $newUser = ["user" => $user->register($email, $name, password_hash($password, PASSWORD_DEFAULT), $token)];

      if (!$newUser["user"]) return ["error" => ["message" => "Erro ao cadastrar usuário. Verifique se já é cadastrado ou entre em contato conosco."], "statusCode" => 400];

      $newUser["message"] = "Usuário cadastrado com sucesso.";
      $newUser["statusCode"] = 201;

      return $newUser;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public static function generateToken() {
    $key = $_ENV["JWT_KEY"];
    $payload = [
      'iss' => 'http://example.org',
      'aud' => 'http://example.com',
      'iat' => 1356999524,
      'nbf' => 1357000000
    ];

    $headers = [
      'x-forwarded-for' => 'www.google.com'
    ];

    $jwt = JWT::encode($payload, $key, 'HS256', null, $headers);

    return $jwt;
  }

  public static function verifyToken($id, $userToken) {
    $user = new User();

    $token = $user->validateToken($id);

    return empty($token) || $userToken !== $token ? ["error" => ["message" => "Token inválido."], "statusCode" => 401] : true;
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

  public static function updateUser($id, $name, $email, $password) {
    try {
      $user = new User();
      $isUpdated = $user->update($id, $name, $email, password_hash($password, PASSWORD_DEFAULT));

      return $isUpdated ? ["message" => "Dados do usuário alterado com sucesso.", "statusCode"  => 200] : ["error" => ["message" => "Erro ao atualizar dados do usuário."], "statusCode" => 400];
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public static function deleteUser($id) {
    try {
      $user = new User();
      $data = $user->delete($id);

      return $data > 0 ? ["message" => "Usuário deletado com sucesso.", "statusCode" => 200] : ["error" => ["message" => "Erro ao deletar usuário. Talvez usuário já tenha sido deletado"], "statusCode" => 400];
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }
}
