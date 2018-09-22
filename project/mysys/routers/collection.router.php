<?php

    $app->get('/collection/id/{id}', function ($request, $response, $args) use ($app) {
        try {
            $id = $args['id'];
            $table='MY_COLLECTION';
            $dbconn = Core::getInstance();
            $sql = "select t.*  "
            . " from MY_COLLECTION t "
            . " WHERE t.id = '$id' ";          
        
            //echo $sql;
            $stmt =  $dbconn->dbh->query($sql);       
            $stmt->execute();
            $collection = $stmt->fetch(PDO::FETCH_OBJ);
            echo json_encode($collection);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->get('/collection', function ($request, $response, $args) use ($app) {	
        try {
            $query =  $request->getQueryParams();
            $table='MY_COLLECTION';
            $dbconn = Core::getInstance();
            $sql = "select t.*  "
            . " from MY_COLLECTION t "
            . " WHERE 1=1 ";
                  
            $category=$query['category'];
            if($category) {
                $sql .= ' and ( ';
                $cat_array = explode(',', $category);
                for($i = 0; $i < count($cat_array); ++$i)  {
                    $sql .=  " '$cat_array[$i]'= t.CATEGORY ";
                    if($i!=count($cat_array) - 1) {
                        $sql .= ' or ';
                    } 
                }
                $sql .= ' ) ';
            }

            $search = $query['search'];
            if($search) {
                $sql .= " and t.CONTENT like '%$search%'";
            }


            //echo $sql;
            $stmt =  $dbconn->dbh->query($sql);       
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->get('/collection/{category}', function ($request, $response, $args) use ($app) {	
        try {
            $category = $args['category'];
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from MY_COLLECTION where CATEGORY='$category'");       
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->get('/collection/random/list', function ($request, $response, $args) use ($app) {	
        try {
            $dbconn = Core::getInstance();
            $stmt =  $dbconn->dbh->query("select * from MY_COLLECTION order by rand() LIMIT 20");       
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

   

    $app->post('/collection', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
      
        $sql = "insert into MY_COLLECTION (CONTENT,  CATEGORY, UPDATE_TIME)"
        . " VALUES('$form[content]', '$form[category]' ,'$date')";
        //return $sql;
        $dbconn->dbh->query($sql);
        
        echo true;
    });

    $app->patch('/collection/times/{id}', function ($request, $response, $args) use ($app) {
        $id = $args['id'];
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "update MY_COLLECTION set TIMES= ifnull(TIMES, 0)+1  where ID='$id'";
        $dbconn->dbh->query($sql);     
        echo $sql ;
    });

    $app->put('/collection/{id}', function ($request, $response, $args) use ($app) {	
        $id = $args['id'];
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "update MY_COLLECTION set CONTENT= '$form[content]' where ID='$id'";
        $dbconn->dbh->query($sql);
        
        echo $sql ;
    });
?>