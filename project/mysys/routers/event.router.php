<?php
     $app->get('/event/{date}', function ($request, $response, $args) use ($app) {	
        try {
            $date = $args['date'];
            $dbconn = Core::getInstance();
            $sql =  "select *  " 
            . " from MY_EVENT  ";
            $stmt =  $dbconn->dbh->query($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($res);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });


    $app->post('/event/{date}', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $date = $args['date'];
        $dbconn = Core::getInstance();
      
        $sql = "insert into MY_EVENT (NAME, CATEGORY, CREATE_TIME)"
        . " VALUES('$form[name]', '$form[category]',  '$date')";
        //return $sql;
        $dbconn->dbh->query($sql);
        echo true;
    });
?>