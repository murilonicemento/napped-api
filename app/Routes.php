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
    $email = $data["email"];
    $token = $request->getHeaderLine('Authorization');
    $response = new AuthResponse();

    if (empty($token)) {
      $response->getBody()->write(json_encode(["error" => ["message" => "Token não fornecido."], "statusCode" => 401]));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(401);
    }

    $isAuth = UserController::verifyToken($email, $token);

    if ($isAuth === true) {
      return $handler->handle($request);
    } else {
      $response->getBody()->write(json_encode($isAuth));

      return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(401);
    }
  };

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

  $app->put("/api/update/{id}", function (Request $request, Response $response) {

    try {
      $id = $request->getAttribute("id");

      $payload = UserController::updateUser($id);
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
  $app->group("/api/private", function ($group) {
    $group->get("/home/{id}", function (Request $request, Response $response) {
      try {
        return $response;
      } catch (\Exception $exception) {
        $response->getBody()->write(json_encode(["error" => "Erro ao tentar acessar rota."]));

        return $response->withHeader("Content-Type", "application/json")->withHeader("Access-Control-Allow-Origin", "http://localhost:5173")->withStatus(500);
      }
    });

    $group->get("/movies", function (Request $request, Response $response) {
    });

    $group->get("/series", function (Request $request, Response $response) {
    });

    $group->get("/animes", function (Request $request, Response $response) {
    });

    $group->get("/games", function (Request $request, Response $response) {
    });
  })->add($authMiddleware);
};
