<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: token, Content-Type');
header("Content-Type: application/json; charset=UTF-8");

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', 'local');

// show errors when working on local
if(APPLICATION_ENV === 'local'){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

require './lib/Config.php';
require './lib/Core.php';
require '../../vendor/autoload.php';
require './configs/'.strtolower(APPLICATION_ENV).'.config.php';


$app = new Slim\App;
$key = 'easontest';

// $app->add(new Tuupola\Middleware\JwtAuthentication([
//     "path" => "/current",
//     "secret" => $key
// ]));

$routers = glob('./routers/*.router.php');
foreach ($routers as $router) {
    require $router;
}

// require './routers/user.router.php';
// require './routers/article.router.php';

$app->run();