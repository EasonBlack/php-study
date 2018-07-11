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

    $app->get('/inspire/{key}', function ($request, $response, $args) use ($app) {	
        $key = $args['key'];
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query("select * from my_inspire where find_in_set('$key',`KEYS`)");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
    });

    $app->post('/inspire', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "insert into MY_INSPIRE (CONTENT, `KEYS`, UPDATE_TIME, STATUS)"
        . " VALUES('$form[content]', '$form[keys]' ,'$date', 'WAIT')";
        $dbconn->dbh->query($sql);
        echo true;
    });
    
    
?>