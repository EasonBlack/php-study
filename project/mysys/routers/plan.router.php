<?php
    $app->get('/plan', function ($request, $response, $args) use ($app) {
      
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query("select * from MY_PLAN");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
    });

    $app->get('/plan/{plandate}', function ($request, $response, $args) use ($app) {
        $plandate = $args['plandate'];
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query("select * from MY_PLAN where PLANDATE='$plandate'");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
    });


    $app->post('/plan', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $sql = "insert into MY_PLAN (NAME, PLANDATE, STATUS)"
        . " VALUES('$form[name]', '$form[plandate]', 0)";
        $dbconn->dbh->query($sql);
        echo true;
    });

    $app->post('/toggleplanstatus/{id}', function ($request, $response, $args) use ($app) {	
        $id = $args['id'];
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $sql = "update MY_PLAN p set STATUS = !p.STATUS where ID='$id'";
        $dbconn->dbh->query($sql);
        echo true;
    });

    $app->put('/plan/{id}', function ($request, $response, $args) use ($app) {	
        $id = $args['id'];
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $sql = "update MY_PLAN set STATUS= '$form[status]' where ID='$id'";
        $dbconn->dbh->query($sql);
        echo true;
    });
?>