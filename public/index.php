<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$app = AppFactory::create();

$authRoutes = require __DIR__ . "/../app/Routes/authRoutes.php";
$privatesRoutes = require __DIR__ . "/../app/Routes/privatesRoutes.php";

$authRoutes($app);
$privatesRoutes($app);

$app->run();
