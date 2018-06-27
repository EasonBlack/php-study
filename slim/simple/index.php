<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
require './mysql.php';

$app = new Slim\App;


$app->get('/', function ($request, $response, $args) {
    $response->write("Welcome to Slim!");
    return $response;
});

$app->get('/hello[/{name}]', function ($request, $response, $args) {
    $response->write("Hello, " . $args['name']);
    return $response;
})->setArgument('name', 'World!');


$app->get('/user', function($request, $response, $args) {
	
    try {
		$conn = connect_db();
        $stmt = $conn->query("select * from user");
		$stmt->execute();
        $names = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo   json_encode($names);
    } catch(PDOException $e) {
        echo  '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/user/{id}', function($request, $response, $args) {
    try {
        $conn = connect_db();
        $id = $args['id'];
        $sql = "SELECT * FROM user WHERE `id` = '$id'";
        $stmt = $conn->query($sql);
		$stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo   json_encode($result);
    } catch(PDOException $e) {
        echo  '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/user', function($request, $response, $args){
    $form = $request->getParsedBody();
    $conn = connect_db();
    $sql = "insert into user (name,role)"
            . " VALUES('$form[name]','$form[role]')";
    $exe = $conn->query($sql);
    echo true;
});

$app->run();
