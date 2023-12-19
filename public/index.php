<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$app = AppFactory::create();

$userRoutes = require __DIR__ . "/../app/Routes/userRoutes.php";
$authRoutes = require __DIR__ . "/../app/Routes/authRoutes.php";

$userRoutes($app);
$authRoutes($app);

$app->run();
