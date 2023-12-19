<?php

namespace App\Routes;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\AuthController;

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
      ->withHeader("Access-Control-Allow-Methods", "GET, OPTIONS");
  });

  $app->get("/validate", function (Request $request, Response $response) {
    try {
      $authorizationHeader = $request->getHeader("Authorization");

      if (!empty($authorizationHeader) && preg_match("/Bearer\s+(.+)/", $authorizationHeader[0], $matches)) {
        $token = $matches[1];

        $payload = AuthController::verifyToken($token);
        $statusCode = $payload["statusCode"];

        $response->getBody()->write(json_encode($payload));

        return $response->withStatus($statusCode);
      } else {
        $response->getBody()->write(json_encode(["error" => "Cabeçalho de autorização ausente ou em formato inválido"]));

        return $response->withStatus(401);
      }
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao tentar validar token do usuário: {$exception}"]));

      return $response->withStatus(500);
    }
  });
};
