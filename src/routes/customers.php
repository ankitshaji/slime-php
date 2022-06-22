<?php
//Server 
//Slim Framework

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

//Server Accepts GET Requests - ALL customers
$app->get('/api/customers', function (Request $request, Response $response) {
    //query
    $query = "SELECT * FROM customers";
    try {
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        //create statement
        $stmt = $db->query($query);
        //Get Request to database
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //return json
        echo json_encode($customers);
    } catch (PDOException $e) {
        echo '{"error":' . $e->getMessage() . '}';
    }
});

//Server Accepts GET Requests - One customer
$app->get('/api/customer/{id}', function (Request $request, Response $response) {
    //get id from url - getAttribute()
    $id = $request->getAttribute('id');
    //query
    $query = "SELECT * FROM customers 
    WHERE id = $id";
    try {
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        //create statement
        $stmt = $db->query($query);
        //Get Request to database
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //return json
        echo json_encode($customer);
    } catch (PDOException $e) {
        echo '{"error":' . $e->getMessage() . '}';
    }
});

//Server Accepts POST Requests - Create customer
$app->post('/api/customer/add', function (Request $request, Response $response) {
    //form info - retrieved params
    //get params from url - getParam()
    $first_name = $request->getParams()['first_name'] ?? '';
    $last_name =  $request->getParams()['last_name'] ?? '';
    $phone =  $request->getParams()['phone'] ?? '';
    $email =  $request->getParams()['email'] ?? '';
    $address =  $request->getParams()['address'] ?? '';
    $city =  $request->getParams()['city'] ?? '';
    $state =  $request->getParams()['state'] ?? '';

    //query
    $query = "INSERT INTO customers (first_name,last_name,phone,email,address,city,state) 
    VALUES(:first_name,:last_name,:phone,:email,:address,:city,:state)";

    try {
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        //bind parameters to placeholders
        $stmt = $db->prepare($query);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"message":"Customer added"}';
    } catch (PDOException $e) {
        echo '{"error":' . $e->getMessage() . '}';
    }
});


//Server Accepts PUT Requests - Update customer
$app->put('/api/customer/update/{id}', function (Request $request, Response $response) {
    //get id from url - getAttribute()
    $id = $request->getAttribute('id');
    //form info - retrieved params
    //get params from url - getParam()
    $first_name = $request->getParams()['first_name'] ?? '';
    $last_name =  $request->getParams()['last_name'] ?? '';
    $phone =  $request->getParams()['phone'] ?? '';
    $email =  $request->getParams()['email'] ?? '';
    $address =  $request->getParams()['address'] ?? '';
    $city =  $request->getParams()['city'] ?? '';
    $state =  $request->getParams()['state'] ?? '';

    //query
    $query = "UPDATE customers SET
    first_name=:first_name,
    last_name = :last_name,
    phone = :phone,
    email = :email,
    address = :address,
    city = :city,
    state = :state
    where id =$id";

    try {
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        //bind parameters to placeholders
        $stmt = $db->prepare($query);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"message":"Customer updated"}';
    } catch (PDOException $e) {
        echo '{"error":' . $e->getMessage() . '}';
    }
});


//Server Accepts DELETE Requests - One customer
$app->delete('/api/customer/delete/{id}', function (Request $request, Response $response) {
    //get id from url - getAttribute()
    $id = $request->getAttribute('id');
    //query
    $query = "DELETE FROM customers 
    WHERE id = $id";
    try {
        //Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();

        //create statement
        $stmt = $db->prepare($query);
        $stmt->execute();

        echo '{"message":"Customer deleted"}';
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":' . $e->getMessage() . '}';
    }
});
