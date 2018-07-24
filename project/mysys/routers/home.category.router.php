<?php
    $app->get('/category', function () use ($app) {	
        try {
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from CATEGORY");
            
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });
?>