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
            $type = $args['type'];
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from MY_KEY where TYPE='$type'");       
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->post('/key', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "insert into MY_KEY (NAME, TYPE)"
        . " VALUES('$form[name]', '$form[type]')";
        $dbconn->dbh->query($sql);
        echo true;
    });

    $app->post('/keylist', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "insert into MY_KEY (NAME, TYPE) VALUES";

        $items = $form['items'];
        for($i = 0; $i < count($items); ++$i)  {
            $sql .=  " ('$items[$i]', '$form[type]')";
            if($i!=count($items) - 1) {
                $sql .= ',';
            } 
        }
        $dbconn->dbh->query($sql);
        echo $sql;
    });

    $app->put('/key/{id}', function ($request, $response, $args) use ($app) {	
        $id = $args['id'];
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "update MY_KEY set NAME='$form[name]' where id='$id'";
        $dbconn->dbh->query($sql);
        echo true;
    });

?>