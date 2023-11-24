<?php

namespace App\Routes;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response as AuthResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Controllers\AuthController;


return function (App $app) {
  $authMiddleware = function (Request $request, RequestHandler $handler) {
    $path = $request->getUri()->getPath();
    $arrPath = explode("/", $path);
    $id = $arrPath[count($arrPath) - 1];
    $token = $request->getHeaderLine("Authorization");
    $response = new AuthResponse();

    if (empty($token)) {
      $response->getBody()->write(json_encode(["error" => ["message" => "Token não fornecido."], "statusCode" => 401]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(401);
    }

    $isAuth = AuthController::verifyToken($id, $token);

    if ($isAuth === true) {
      return $handler->handle($request);
    } else {
      $response->getBody()->write(json_encode($isAuth));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(401);
    }
  };

  $app->group("/api/private", function ($group) {
    $group->get("/home/{id}", function (Request $request, Response $response) {
      try {
        $response->getBody()->write(json_encode(["success" => true, "statusCode" => 200]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(200);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(500);
      }
    });

    $group->get("/movies/{id}", function (Request $request, Response $response) {
      try {
        $response->getBody()->write(json_encode(["success" => true, "statusCode" => 200]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(200);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(500);
      }
    });

    $group->get("/series/{id}", function (Request $request, Response $response) {
      try {
        $response->getBody()->write(json_encode(["success" => true, "statusCode" => 200]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(200);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(500);
      }
    });

    $group->get("/animes/{id}", function (Request $request, Response $response) {
      try {
        $response->getBody()->write(json_encode(["success" => true, "statusCode" => 200]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(200);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(500);
      }
    });

    $group->get("/games/{id}", function (Request $request, Response $response) {
      try {
        $response->getBody()->write(json_encode(["success" => true, "statusCode" => 200]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(200);
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withHeader('Access-Control-Allow-Headers', 'Content-Type')->withStatus(500);
      }
    });
  })->add($authMiddleware);
};
