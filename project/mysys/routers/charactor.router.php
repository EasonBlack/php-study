<?php
    $app->get('/boko/{id}/charactor', function ($request, $response, $args) use ($app) {	
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
?>