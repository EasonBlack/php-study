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

    
    $app->post('/key', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "insert into MY_KEY (NAME)"
        . " VALUES('$form[name]')";
        $dbconn->dbh->query($sql);
        echo true;
    });

    $app->post('/keylist', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "insert into MY_KEY (NAME) VALUES";

        $items = $form['items'];
        for($i = 0; $i < count($items); ++$i)  {
            $sql .=  " ('$items[$i]')";
            if($i!=count($items) - 1) {
                $sql .= ',';
            } 
        }
        $dbconn->dbh->query($sql);
        echo $sql;
    });


?>