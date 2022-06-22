<?php
//Server 

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

//Get All Customers
$app->get('/api/customers', function (Request $request, Response $response) {
    echo 'CUSTOMERS';
    
});
