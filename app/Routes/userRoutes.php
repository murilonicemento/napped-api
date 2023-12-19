<?php

namespace App\Routes;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->options("/{routes:.+}", function ($request, $response, $args) {
    return $response;
  });

  $app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
      ->withHeader("Content-Type", "application/json")
      ->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")
      ->withHeader("Access-Control-Allow-Headers", "Content-Type, Authorization")
      ->withHeader("Access-Control-Allow-Methods", "POST, DELETE, OPTIONS");
  });

  $app->group("/api", function (RouteCollectorProxy $group) {
    $group->post("/register", function (Request $request, Response $response) {
      try {
        $data = $request->getParsedBody();
        $payload = AuthController::registerUser($data["name"], $data["email"], $data["password"]);
        $statusCode = $payload["statusCode"];

        $response->getBody()->write(json_encode($payload));

        return $response->withStatus($statusCode);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar criar usuário: {$exception}"]));

        return $response->withStatus(500);
      }
    });

    $group->post("/login", function (Request $request, Response $response) {
      try {
        $data = $request->getParsedBody();

        $payload = AuthController::loginUser($data["email"], $data["password"]);
        $statusCode = $payload["statusCode"];

        $response->getBody()->write(json_encode($payload));

        return $response->withStatus($statusCode);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao realizar login: {$exception}"]));

        return $response->withStatus(500);
      }
    });

    $group->post("/update/{id}", function (Request $request, Response $response, array $args) {
      try {
        $data = $request->getParsedBody();
        $payload = UserController::updateUser($args["id"], $data["name"] ?? null, $data["email"] ?? null, $data["password"] ?? null);
        $statusCode = $payload["statusCode"];

        $response->getBody()->write(json_encode($payload));

        return $response->withStatus($statusCode);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar atualizar usuário: {$exception}"]));

        return $response->withStatus(500);
      }
    });

    $group->delete("/delete/{id}", function (Request $request, Response $response) {
      try {
        $id = $request->getAttribute("id");

        $payload = UserController::deleteUser($id);
        $statusCode = $payload["statusCode"];

        $response->getBody()->write(json_encode($payload));

        return $response->withStatus($statusCode);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar deletar usuário: {$exception}"]));

        return $response->withStatus(500);
      }
    });
  });
};
