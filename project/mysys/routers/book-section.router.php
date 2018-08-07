<?php

    // Get all book Sections
    $app->get('/book/{id}/section', function ($request, $response, $args) use ($app) {	
        $id = $args['id'];
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query("select * from BOOK_SECTION where BOOK_ID='$id'");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
    });

    $app->post('/book/{id}/section', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $id = $args['id'];
        $dbconn = Core::getInstance();
      
        $sql = "insert into BOOK_SECTION (NAME, BOOK_ID, PARENT_ID)"
        . " VALUES('$form[name]',  '$id', '$form[parent_id]')";
        //return $sql;
        $dbconn->dbh->query($sql);
        echo true;
    });


    $app->get('/book-section/{id}/content', function ($request, $response, $args) use ($app) {	
       
        $id = $args['id'];
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query("select * from BOOK_CONTENT where SECTION_ID='$id'");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
    });

    $app->post('/book-section/{id}/content', function ($request, $response, $args) use ($app) {	
       
        $form = $request->getParsedBody();
        $id = $args['id'];
        $dbconn = Core::getInstance();
      
        $sql = "insert into BOOK_CONTENT (SECTION_ID,CONTENT)"
        . " VALUES( '$id', '$form[content]')";
        //return $sql;
        $dbconn->dbh->query($sql);
        echo true;
    });


    $app->get('/book-content/{id}', function ($request, $response, $args) use ($app) {	
       
        $id = $args['id'];
        $dbconn = Core::getInstance();
        $stmt =  $dbconn->dbh->query("select * from BOOK_CONTENT where ID='$id'");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($results);
    });


    $app->put('/book-content/{id}', function ($request, $response, $args) use ($app) {	
        $form = $request->getParsedBody();
        $id = $args['id'];
        $dbconn = Core::getInstance();
        $sql = "update BOOK_CONTENT set CONTENT='$form[content]' where ID='$id'";
        
        $dbconn->dbh->query($sql);  

        echo true;
    });


  

?>