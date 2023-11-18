<?php

namespace App;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\UserController;


return function (App $app) {
  $app->post("/api/register", function (Request $request, Response $response) {
    try {
      $data = $request->getParsedBody();
      $payload = UserController::registerUser($data["name"], $data["email"], $data["password"]);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao tentar criar usuário"]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(500);
    }
  });

  $app->post("/api/login", function (Request $request, Response $response) {
    try {
      $data = $request->getParsedBody();

      $payload = UserController::loginUser($data["email"], $data["password"]);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao realizar login"]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(500);
    }
  });

  $app->post("/api/update", function (Request $request, Response $response) {
    try {
      $data = $request->getParsedBody();

      $payload = UserController::updateUser($data["id"], $data["name"], $data["email"], $data["password"]);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao tentar atualizar usuário"]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(500);
    }
  });

  $app->delete("/api/delete/{id}", function (Request $request, Response $response) {
    try {
      $id = $request->getAttribute("id");

      $payload = UserController::deleteUser($id);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao tentar deletar usuário."]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(500);
    }
  });
};
