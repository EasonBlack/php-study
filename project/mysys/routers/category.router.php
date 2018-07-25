<?php

    $app->get('/category', function () use ($app) {	
        try {
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from MY_CATEGORY");
            
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });


    $app->post('/category', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $sql = "insert into MY_CATEGORY (NAME, PARENT_ID)"
        . " VALUES('$form[name]', '$form[parentId]')";
        $dbconn->dbh->query($sql);
        echo true;
    });


?>