<?php
//Server
//composer require slim/slim "^3.0"

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

require '../vendor/autoload.php';
require '../src/config/db.php';

// Define app routes
$app = new \Slim\App;

//Server accepts GET request
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
    return $response;
});

//Customer Routes
require '../src/routes/customers.php';

// Run app
$app->run();
