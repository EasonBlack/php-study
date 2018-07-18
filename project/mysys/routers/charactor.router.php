<?php
    $app->get('/book/{id}/charactor', function ($request, $response, $args) use ($app) {	
        try {
            $id = $args['id'];
            $dbconn = Core::getInstance();
            $sql = "select * from CHARACTOR WHERE BOOK_ID='$id'";
            $stmt =  $dbconn->dbh->query($sql);       
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }  
    });


    $app->post('/book/{id}/charactor', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $id = $args['id'];
        $dbconn = Core::getInstance();
      
        $sql = "insert into CHARACTOR (BOOK_ID,NAME,`DESC`,RELATIONSHIP)"
        . " VALUES('$id', '$form[name]', '$form[desc]' ,'$form[relationship]')";
        //return $sql;
        $dbconn->dbh->query($sql);
        
        echo true;
    });


    $app->put('/book/{id}/charactor', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $id = $args['id'];
        $dbconn = Core::getInstance();
        $sql = "update CHARACTOR set NAME='$form[name]',`DESC`='$$form[name]', RELATIONSHIP='$form[relationship]' where id='$id'";
        //return $sql;
        $dbconn->dbh->query($sql);
        
        echo true;
    });
?>