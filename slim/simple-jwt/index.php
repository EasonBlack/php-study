<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
use \Firebase\JWT\JWT;


$app = new Slim\App;
$key = "easontest";
$token = array(
    "name" => "xxxxxxxxxx",
    "email" => "yyyyyyyyyyy"
);
$jwt = JWT::encode($token, $key);
$app->add(new Tuupola\Middleware\JwtAuthentication([
    "path" => "/t",
    "secret" => $key
]));


$app->get('/t', function ($request, $response, $args) {
    //通过  'Authorization': 'Bearer ' + _token 传入
    $token = $request->getAttribute("token");
    echo json_encode($token);
    $response->write("Welcome to Slim!");
    return $response;
});


$app->get('/g', function ($request, $response, $args) {
    global $jwt;
    return  $jwt;
});




$app->run();
