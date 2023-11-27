<?php

namespace App\Routes;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\AuthController;
use App\Controllers\UserController;

return function (App $app) {
  $app->post("/api/register", function (Request $request, Response $response) {
    try {
      $data = $request->getParsedBody();
      $payload = AuthController::registerUser($data["name"], $data["email"], $data["password"]);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao tentar criar usuário"]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(500);
    }
  });

  $app->post("/api/login", function (Request $request, Response $response) {
    try {
      $data = $request->getParsedBody();

      $payload = AuthController::loginUser($data["email"], $data["password"]);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao realizar login"]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(500);
    }
  });

  $app->put("/api/update/{id}[/{name}[/{email}[/password]]]", function (Request $request, Response $response, array $args) {
    try {
      $payload = UserController::updateUser($args["id"], $args["name"] ?? null, $args["email"] ?? null, $args["password"] ?? null);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao tentar atualizar usuário"]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(500);
    }
  });

  $app->delete("/api/delete/{id}", function (Request $request, Response $response) {
    try {
      $id = $request->getAttribute("id");

      $payload = UserController::deleteUser($id);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao tentar deletar usuário."]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(500);
    }
  });
  $app->post("/api/validate", function (Request $request, Response $response) {

    try {
      $data = $request->getParsedBody();

      $payload = AuthController::verifyToken($data["id"], $data["access_token"]);
      $statusCode = $payload["statusCode"];

      $response->getBody()->write(json_encode($payload));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus($statusCode);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao tentar deletar usuário."]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(500);
    }
  });
};
