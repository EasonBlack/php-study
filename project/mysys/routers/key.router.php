<?php

    $app->get('/key', function () use ($app) {	
        try {
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from MY_KEY");
            
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->get('/key/{type}', function ($request, $response, $args) use ($app) {	     
        try {
    $app->post('/key', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d h:i:s");
        $sql = "insert into MY_KEY (NAME, TYPE)"
        . " VALUES('$form[name]', '$form[type]')";
        $dbconn->dbh->query($sql);
        echo true;
    });

    $app->put('/key/{id}', function ($request, $response, $args) use ($app) {	
        $id = $args['id'];
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d h:i:s");
        $sql = "update MY_KEY set NAME='$form[name]' where id='$id'";
        $dbconn->dbh->query($sql);
        echo true;
    });

?>