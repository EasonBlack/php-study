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

    $app->get('/charactor/{id}', function ($request, $response, $args) use ($app) {	
        try {
            $id = $args['id'];
            $dbconn = Core::getInstance();
            $sql = "select * from CHARACTOR_CONTENT WHERE CID='$id'";
            $stmt =  $dbconn->dbh->query($sql);       
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }  
    });

    $app->get('/charactor-content/{id}', function ($request, $response, $args) use ($app) {	
        try {
            $id = $args['id'];
            $dbconn = Core::getInstance();
            $sql = "select * from CHARACTOR_CONTENT WHERE ID='$id'";
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


    $app->post('/charactor/{id}', function ($request, $response, $args) use ($app) {	
        try {
            $id = $args['id'];
            $form = $request->getParsedBody();

            $dbconn = Core::getInstance();

            $sql = "insert into CHARACTOR_CONTENT (CID,NAME,CONTENT)"
            . " VALUES('$id', '$form[name]', '$form[content]')";
            //echo $sql;
            $stmt =  $dbconn->dbh->query($sql);       
          
            echo true;
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }  
    });

    $app->put('/charactor/{cid}/{id}', function ($request, $response, $args) use ($app) {	
        try {
            $cid = $args['cid'];
            $id = $args['id'];
            $form = $request->getParsedBody();

            $dbconn = Core::getInstance();

            $sql = "update CHARACTOR_CONTENT " 
            . " set NAME='$form[name]',`CONTENT`='$$form[content]'" 
            . " where id='$id'";

            $stmt =  $dbconn->dbh->query($sql);       
            echo true;
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }  
    });
?>