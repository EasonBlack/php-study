<?php
    
    $app->get('/daily', function () use ($app) {	
        try {
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from DAILY_NOTE order by CREATE_TIME desc");
            
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($res);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });


    $app->post('/daily', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d h:i:s");
        $sql = "insert into DAILY_NOTE (CONTENT, CREATE_TIME)"
        . " VALUES('$form[content]', '$date')";
        $dbconn->dbh->query($sql);
        echo $dbconn->dbh->lastInsertId();
    });
?>