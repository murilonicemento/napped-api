<?php

namespace App;

use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\User;

return function (App $app) {
  $app->get('/api/register', function (Request $request, Response $response) {
    $users = new User();
    $data = json_encode($users->getUser());

    $response->getBody()->write($data);
    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(201);
    return $response->getBody()->write($users->getUser());
  });
};
