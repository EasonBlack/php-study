<?php
header("Content-Type: application/json; charset=UTF-8");

$app->get('/a', function () use ($app) {
    
    $date = date("Y-m-d H:i:s");
    echo $date;
});	

// Get current 
$app->get('/current', function () use ($app) {	
    try {
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query("select * from CURRENT");
        
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($articles);
    }  catch(PDOException $e) {
        echo  '{"error":{"text":'. $e->getMessage() .'}}';
    }
});


$app->get('/current/{id}', function ($request, $response, $args) use ($app) {	
    $id = $args['id'];
    $dbconn = Core::getInstance();
    $stmt =  $dbconn->dbh->query("select * from current where id='$id'");
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_OBJ);
	echo json_encode($articles);
});

$app->post('/current', function ($request, $response, $args) use ($app) {	
    $form = $request->getParsedBody();
    $dbconn = Core::getInstance();
    $date = date("Y-m-d h:i:s");
    $sql = "insert into CURRENT (CONTENT, UPDATE_TIME)"
    . " VALUES('$form[content]', '$date')";
    $dbconn->dbh->query($sql);
	echo true;
});

$app->put('/current/{id}', function ($request, $response, $args) use ($app) {	
    $id = $args['id'];
    $form = $request->getParsedBody();
    $dbconn = Core::getInstance();
    $date = date("Y-m-d h:i:s");
    $sql = "update CURRENT set CONTENT='$form[content]',UPDATE_TIME='$date' where id='$id'";
    $dbconn->dbh->query($sql);
	echo true;
});

?>