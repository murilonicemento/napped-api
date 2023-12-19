<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$app = AppFactory::create();

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

$userRoutes = require __DIR__ . "/../app/Routes/userRoutes.php";
$authRoutes = require __DIR__ . "/../app/Routes/authRoutes.php";

$userRoutes($app);
$authRoutes($app);

$app->run();
