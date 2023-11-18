<?php

namespace App;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response as AuthResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Controllers\UserController;


return function (App $app) {
  $authMiddleware = function (Request $request, RequestHandler $handler) {
    $data = $request->getParsedBody();
    $id = $data["id"];
    $token = $request->getHeaderLine("Authorization");
    $response = new AuthResponse();

    if (empty($token)) {
      $response->getBody()->write(json_encode(["error" => ["message" => "Token não fornecido."], "statusCode" => 401]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(401);
    }

    $isAuth = UserController::verifyToken($id, $token);

    if ($isAuth === true) {
      return $handler->handle($request);
    } else {
      $response->getBody()->write(json_encode($isAuth));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(401);
    }
  };

  $app->group("/api/private", function ($group) {
    $group->post("/home", function (Request $request, Response $response) {
      try {
        $response->getBody()->write(json_encode(["success" => true, "statusCode" => 200]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(200);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(500);
      }
    });

    $group->post("/movies", function (Request $request, Response $response) {
      try {
        $response->getBody()->write(json_encode(["success" => true, "statusCode" => 200]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(200);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(500);
      }
    });

    $group->post("/series", function (Request $request, Response $response) {
      try {
        $response->getBody()->write(json_encode(["success" => true, "statusCode" => 200]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(200);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(500);
      }
    });

    $group->post("/animes", function (Request $request, Response $response) {
      try {
        $response->getBody()->write(json_encode(["success" => true, "statusCode" => 200]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(200);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(500);
      }
    });

    $group->post("/games", function (Request $request, Response $response) {
      try {
        $response->getBody()->write(json_encode(["success" => true, "statusCode" => 200]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(200);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(500);
      }
    });
  })->add($authMiddleware);
};
