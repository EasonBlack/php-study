<?php


    $app->get('/collection', function ($request, $response, $args) use ($app) {	
        try {
            $query =  $request->getQueryParams();
            $table='MY_COLLECTION';
            $dbconn = Core::getInstance();
            $sql = "select t.*  "
            . " from MY_COLLECTION t "
            . " WHERE 1=1 ";
            
            // $category = $query['category'];
            // if($category) {
            //     $sql .= " and t.CATEGORY='$category'";
            // }


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


    $app->put('/collection/{id}', function ($request, $response, $args) use ($app) {	
        $id = $args['id'];
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "update MY_COLLECTION set CONTENT= '$form[content]', UPDATE_TIME='$date' where ID='$id'";
        $dbconn->dbh->query($sql);
        
        echo $sql ;
    });
?>