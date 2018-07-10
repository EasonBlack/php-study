<?php
    $app->get('/collection/it/{category}', function ($request, $response, $args) use ($app) {	
        try {
            $category = $args['category'];
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from COLLECTION_IT where CATEGORY='$category'");       
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->get('/collection/it', function ($request, $response, $args) use ($app) {	
      
        $query =  $request->getQueryParams();
        $sql = 'select * from COLLECTION_IT where 1=1 ';
        $id = $query['id'];
        if($id) {
            $sql .= "and ID= '$id' ";
        }
        
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query($sql);       
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
        
    });


    $app->get('/collection/lit/{category}', function ($request, $response, $args) use ($app) {	
        try {
            $category = $args['category'];
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from COLLECTION_LIT where CATEGORY='$category'");       
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->get('/collection/lit', function ($request, $response, $args) use ($app) {	
      
        $query =  $request->getQueryParams();
        $sql = 'select * from COLLECTION_LIT where 1=1 ';
        $id = $query['id'];
        if($id) {
            $sql .= "and ID= '$id' ";
        }
        
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query($sql);       
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
        
    });


    $app->post('/collection', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $_table = $form['table'];
        $table = '';
        if($_table=='it') {
            $table='COLLECTION_IT';
        } else if($_table=='lit'){
            $table='COLLECTION_LIT';
        }
        $sql = "insert into ".$table." (CONTENT, `KEYS`, CATEGORY, UPDATE_TIME)"
        . " VALUES('$form[content]', '$form[keys]', '$form[category]' ,'$date')";
        //return $sql;
        $dbconn->dbh->query($sql);
        
        echo true;
    });
?>