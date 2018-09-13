<?php

$app->get('/wy-customer', function () use ($app) {	
    $dbconn = Core::getInstance();
    $stmt =  $dbconn->dbh->query("select * from WY_CUSTOMER");
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
	echo json_encode($customers);
});

$app->post('/wy-customer', function ($request, $response, $args) use ($app) {	
    $form = $request->getParsedBody();
    $dbconn = Core::getInstance();
    $date = date("Y-m-d H:i:s");
    $sql = "insert into WY_CUSTOMER (NAME)"
    . " VALUES('$form[name]')";
    $dbconn->dbh->query($sql);
    echo true; 
});

$app->put('/wy-customer/{id}', function ($request, $response, $args) use ($app) {	
    $id = $args['id'];
    $form = $request->getParsedBody();
    $dbconn = Core::getInstance();
    $sql = "update WY_CUSTOMER set NAME='$form[name]' where ID='$id'";
    $dbconn->dbh->query($sql);
    echo true; 
});


$app->get('/wy-order/id/{id}', function ($request, $response, $args) use ($app) {	
    $id = $args['id'];
    $dbconn = Core::getInstance();
    $stmt =  $dbconn->dbh->query("select * from WY_CUSTOMER where ID='$id'");
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_OBJ);
	echo json_encode($order);
});

$app->get('/wy-order/date/{date}', function ($request, $response, $args) use ($app) {	
    $date = $args['date'];
    $dbconn = Core::getInstance();
    $stmt =  $dbconn->dbh->query("select * from WY_CUSTOMER where DATE='$date'");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
	echo json_encode($result);
});

$app->get('/wy-order/month/{yearmonth}', function ($request, $response, $args) use ($app) {	
    $yearmonth = $args['yearmonth'];
    $dbconn = Core::getInstance();
    $stmt =  $dbconn->dbh->query("select * from WY_CUSTOMER where DATE_FORMAT(DATE, '%Y-%m')='$yearmonth'");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
	echo json_encode($result);
});


$app->post('/wy-order', function ($request, $response, $args) use ($app) {	
    $form = $request->getParsedBody();
    $dbconn = Core::getInstance();
    $sql = "insert into WY_ORDER (DATE, TIME, CUSTOMER_ID)"
    . " VALUES('$form[date]', '$form[time]', $form[customer_id])";
    $dbconn->dbh->query($sql);
    echo true; 
});

$app->put('/wy-order/{id}', function ($request, $response, $args) use ($app) {	
    $id = $args['id'];
    $form = $request->getParsedBody();
    $dbconn = Core::getInstance();
    $sql = "update WY_ORDER set DATE='$form[date]',`TIME`='$$form[time]', CUSTOMER_ID='$form[customer_id]' where ID='$id'";
    $dbconn->dbh->query($sql);
    echo true; 
});


?>