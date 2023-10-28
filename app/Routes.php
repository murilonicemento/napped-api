<?php

namespace App;

use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Controllers\UserController;

return function (App $app) {
  $app->post("/api/register", function (Request $request, Response $response) {
    try {
      $data = $request->getParsedBody();
      $payload = UserController::registerUser($data["name"], $data["email"], $data["password"]);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao tentar criar usuário"]));

      return $response->withHeader("Content-Type", "application/json")->withStatus(500);
    }
  });

  $app->post("/api/login", function (Request $request, Response $response) {
    try {
      $data = $request->getParsedBody();

      $payload = UserController::loginUser($data["email"], $data["password"]);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao realizar login"]));

      return $response->withHeader("Content-Type", "application/json")->withStatus(500);
    }
  });
};
