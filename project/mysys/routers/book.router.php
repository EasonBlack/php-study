<?php
    $app->get('/book', function ($request, $response, $args) use ($app) {	
        try {
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from BOOK");
            
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }  
    });

    $app->get('/book/{id}', function ($request, $response, $args) use ($app) {	
        try {
            $id = $args['id'];
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from BOOK where ID='$id'");
            
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }  
    });

    
?>