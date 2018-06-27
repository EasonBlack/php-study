<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';

$app = new Slim\App;


$app->get('/', function ($request, $response, $args) {
    $response->write("Welcome to Slim!");
    return $response;
});

$app->get('/hello[/{name}]', function ($request, $response, $args) {
    $response->write("Hello, " . $args['name']);
    return $response;
})->setArgument('name', 'World!');

$servername="localhost";
$username = "root";
$password = "root";

$app->get('/demo', function($request, $response, $args) {
	global $servername,$username, $password;

    try {
		$conn = new PDO("mysql:host=$servername;dbname=demo", $username, $password);
        $stmt = $conn->query("select * from user");
		$stmt->execute();
        $names = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo   json_encode($names);
    } catch(PDOException $e) {
        echo  '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->run();
