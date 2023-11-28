<?php

namespace App\Controllers;

use App\Models\Auth;
use Firebase\JWT\JWT;

class AuthController {
  public static function registerUser($email, $name, $password) {
    try {
      $auth = new Auth();

      $newUser = ["user" => $auth->register($email, $name, password_hash($password, PASSWORD_DEFAULT))];

      if (!$newUser["user"]) return ["error" => ["message" => "Erro ao cadastrar usuário. Verifique se já é cadastrado ou entre em contato conosco."], "statusCode" => 400];

      $newUser["message"] = "Usuário cadastrado com sucesso.";
      $newUser["statusCode"] = 201;

      return $newUser;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }

  public static function generateToken($id) {
    $key = $_ENV["JWT_KEY"];
    $payload = [
      "sub" => $id,
      'iss' => $_ENV["JWT_ISS"],
      'aud' => $_ENV["JWT_AUD"],
      'iat' => 1356999524,
      'nbf' => 1357000000,
      "exp" => time() + (90 * 24 * 60 * 60)
    ];

    $headers = [
      "x-forwarded-for" => "www.google.com"
    ];

    $jwt = JWT::encode($payload, $key, "HS256", null, $headers);

    return $jwt;
  }

  public static function verifyToken($userToken) {
    $auth = new Auth();

    $user = $auth->validateToken($userToken);

    return empty($user) ? ["error" => ["message" => "Token inválido."], "statusCode" => 401] : ["user" => $user, "validated" => true, "statusCode" => 200];
  }

  public static function loginUser($email, $password) {
    try {
      $auth = new Auth();
      $data = ["user" => $auth->login($email)];

      if (!$data["user"]) return ["error" => ["message" => "Usuário não cadastrado ou credenciais incorretas."], "statusCode" => 400];

      if (!password_verify($password, $data["user"]["password"])) return ["error" => ["message" => "Usuário ou senha inválidos. Verifique suas credenciais."], "statusCode" => 401];

      $token = self::generateToken($data["user"]["id"]);

      $user = ["user" => $auth->updateToken($data["user"]["email"], $token)];

      $user["message"] = "Login bem-sucedido.";
      $user["statusCode"] = 200;

      return $user;
    } catch (\Exception $exception) {
      throw $exception->getMessage();
    }
  }
}
