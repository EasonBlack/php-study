<?php

// Get user
$app->get('/user', function () use ($app) {	
    
    $dbconn = Core::getInstance();
    $stmt =  $dbconn->dbh->query("select * from user");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
	echo json_encode($users);
});

?>