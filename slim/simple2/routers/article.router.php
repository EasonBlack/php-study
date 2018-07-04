<?php

// Get user
$app->get('/article', function () use ($app) {	
    
    $dbconn = Core::getInstance();
    $stmt =  $dbconn->dbh->query("select * from article");
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_OBJ);
	echo json_encode($articles);
});

?>