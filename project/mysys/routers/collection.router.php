<?php
    $app->get('/collection/it/{category}', function ($request, $response, $args) use ($app) {	
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
?>