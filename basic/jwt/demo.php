<?php
    require '../../vendor/autoload.php';
    use \Firebase\JWT\JWT;

    $key = "easontest";
    $token = array(
        "name" => "xxxxxxxxxx",
        "email" => "yyyyyyyyyyy"
    );

    $jwt = JWT::encode($token, $key);
    $decoded = JWT::decode($jwt, $key, array('HS256'));

    print_r($jwt);
    echo "<br>";
    print_r($decoded);
?>
