<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
  $data = ["nome" => "Murilo", "idade" => 20];
  $payload = json_encode($data);
  $response->getBody()->write($payload);

  return $response->withHeader("Content-Type", "application/json")->withStatus(200);
});

$app->run();
