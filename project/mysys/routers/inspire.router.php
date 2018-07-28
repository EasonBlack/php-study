<?php

    $app->get('/inspire', function ($request, $response, $args) use ($app) {	
        try {
            $query =  $request->getQueryParams();
            $dbconn = Core::getInstance();


            $sql = "select t.*, GROUP_CONCAT(k.NAME) as KEYS_NAME "
            . " from MY_KEY k "
            . " join MY_INSPIRE t  "
            . " ON FIND_IN_SET(k.ID, t.KEYS) > 0 " 
            . " WHERE 1=1 ";

            $key=$query['key'];
            if($key) {
                $sql .= ' and ( ';
                $key_array = explode(',', $key);
                for($i = 0; $i < count($key_array); ++$i)  {
                    $sql .=  " find_in_set('$key_array[$i]' , t.KEYS) ";
                    if($i!=count($key_array) - 1) {
                        $sql .= ' and ';
                    } 
                }
                $sql .= ' ) ';
            }

            $search = $query['search'];
            if($search) {
                $sql .= " and t.CONTENT like '%$search%'";
            }

            $sql .= 'GROUP BY t.ID';

            $stmt =  $dbconn->dbh->query($sql);         
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($results);
        }  catch(PDOException $e) {
            echo  '{"error":{"text":'. $e->getMessage() .'}}';
        }
    });

    $app->get('/inspire/{key}', function ($request, $response, $args) use ($app) {	
        $key = $args['key'];
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query("select * from my_inspire where find_in_set('$key',`KEYS`)");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
    });

    $app->post('/inspire', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
        $sql = "insert into MY_INSPIRE (CONTENT, `KEYS`, UPDATE_TIME, STATUS)"
        . " VALUES('$form[content]', '$form[keys]' ,'$date', 'WAIT')";
        $dbconn->dbh->query($sql);
        echo true;
    });
    

    $app->put('/inspire/{id}', function ($request, $response, $args) use ($app) {	
        $id = $args['id'];
        $form = $request->getParsedBody();
        $dbconn = Core::getInstance();
        $date = date("Y-m-d H:i:s");
       
        $sql = "update MY_INSPIRE set CONTENT= '$form[content]', `KEYS`='$form[keys]'  where ID='$id'";
        $dbconn->dbh->query($sql);
        echo true;
    });
    
?>