<?php

namespace App;

use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Controllers\UserController;

return function (App $app) {
  $app->post('/api/register', function (Request $request, Response $response) {
    try {
      $data = $request->getParsedBody();
      $payload = json_encode(UserController::registerUser($data["name"], $data["email"], $data["password"]));

      if (isset($payload["error"])) {
        $response->getBody()->write($payload["error"]);

        return $response->withHeader("Content-Type", "application/json")->withStatus(400);
      }

      $response->getBody()->write($payload);

      return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    } catch (\Exception $exception) {
      $response->getBody()->write(json_encode(["error" => "Erro ao tentar criar usuário"]));

      return $response->withHeader("Content-Type", "application/json")->withStatus(400);
    }
  });
};
