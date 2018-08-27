<?php
    $app->get('/timecounter', function ($request, $response, $args) use ($app) {
      
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query("select * from my_time_count");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
    });


    $app->post('/timecounter', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "insert into my_time_count (TIME_COUNT)"
        . " VALUES('$form[count]')";
        $dbconn->dbh->query($sql);
        echo true;
    });
?>