<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\User;
use App\Controllers\UserController;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$app = AppFactory::create();


$app->get('/', function (Request $request, Response $response) {
  $users = new User();
  $data = json_encode($users->getUser());

  $response->getBody()->write($data);
  return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus(201);
  return $response->getBody()->write($users->getUser());
});

$app->run();
