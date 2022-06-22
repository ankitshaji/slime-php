<?php
//Server 

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

//Server Accepts Get Requests - ALL customers
$app->get('/api/customers', function (Request $request, Response $response) {
    //query
    $query = "SELECT * FROM customers";
    try {
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();
    } catch (PDOException $e) {
        echo '{"error":' . $e->getMessage() . '}';
    }
    //create statement
    $stmt = $db->query($query);
    //Get Request to database
    $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    //return json
    echo json_encode($customers);
});

//Server Accepts Get Requests - One customer
$app->get('/api/customer/{id}', function (Request $request, Response $response) {
    //getid
    $id = $request->getAttribute('id');
    //query
    $query = "SELECT * FROM customers 
    WHERE id = $id";
    try {
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();
    } catch (PDOException $e) {
        echo '{"error":' . $e->getMessage() . '}';
    }
    //create statement
    $stmt = $db->query($query);
    //Get Request to database
    $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    //return json
    echo json_encode($customer);
});
