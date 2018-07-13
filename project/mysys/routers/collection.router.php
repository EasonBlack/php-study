<?php


    $app->get('/collection', function ($request, $response, $args) use ($app) {	
        try {
            $query =  $request->getQueryParams();
            $type = $query['type'];
            $table = '';
            if($type=='it') {
                $table='COLLECTION_IT';
            } else if($type=='lit'){
                $table='COLLECTION_LIT';
            }
            $dbconn = Core::getInstance();
            $sql = "select t.*, GROUP_CONCAT(k.NAME) as KEYS_NAME "
            . " from MY_KEY k "
            . " join ".$table." t  "
            . " ON FIND_IN_SET(k.ID, t.KEYS) > 0 " 
            . " WHERE 1=1 ";
            //$sql = "select * from ".  $table . " where 1=1 ";
            
            $category = $query['category'];
            if($category) {
                $sql .= " and t.CATEGORY='$category'";
            }

            $key=$query['key'];
            if($key) {
                $sql .= ' and ( ';
                $key_array = explode(',', $key);
                for($i = 0; $i < count($key_array); ++$i)  {
                    $sql .=  " find_in_set('$key_array[$i]' , t.KEYS) ";
                    if($i!=count($key_array) - 1) {
                        $sql .= ' or ';
                    } 
                }
                $sql .= ' ) ';
            }

            $sql .= 'GROUP BY t.ID';
            //echo $sql;
            $stmt =  $dbconn->dbh->query($sql);       
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

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