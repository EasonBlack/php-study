<?php

// Get user
$app->get('/user', function () use ($app) {	
    
    $dbconn = Core::getInstance();
    $stmt =  $dbconn->dbh->query("select * from USER");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
	echo json_encode($users);
});

$app->post('/user', function ($request, $response, $args) use ($app) {	
    $form = $request->getParsedBody();
    $dbconn = Core::getInstance();
    $stmt =  $dbconn->dbh->query("select * from USER where NAME='$form[name]' and PASSWORD = '$form[password]'");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    echo empty($user) ? 0 : $user->ID;
   
});

?>