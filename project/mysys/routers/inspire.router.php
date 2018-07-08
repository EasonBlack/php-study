<?php

    $app->get('/inspire', function () use ($app) {	
        try {
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from MY_INSPIRE");         
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->get('/inspire/{id}', function ($request, $response, $args) use ($app) {	
        $id = $args['id'];
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query("select * from MY_INSPIRE where ID='$id'");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
    });

    $app->post('/inspire', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d h:i:s");
        $sql = "insert into MY_INSPIRE (CONTENT, KEYS, UPDATE_TIME)"
        . " VALUES('$form[content]', '$form[keys]' ,'$date')";
        $dbconn->dbh->query($sql);
        echo true;
    });
    
    $app->put('/inspire/{id}', function ($request, $response, $args) use ($app) {	
        $id = $args['id'];
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d h:i:s");
        $sql = "update MY_INSPIRE set CONTENT='$form[content]',KEYS='$form[keys]', UPDATE_TIME='$date' where id='$id'";
        $dbconn->dbh->query($sql);
        echo true;
    });
?>