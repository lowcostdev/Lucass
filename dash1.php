<?php

include "include/db_config.php";

if(isset($_POST['search'])){
 	$search = $_POST['search'];

    $clients = $pdo->prepare("SELECT * FROM customers WHERE custname LIKE :name ");
    $clients->execute( array(':name' => '%' . $search . '%'));
    $result =  $clients->fetchAll();


 $response = array();
 while($row = mysqli_fetch_array($result) ){
   $response[] = array("value"=>$rows['cust_name'],"label"=>$row['cust_name']);
 }

 echo json_encode($response);
}

exit;


/*
	$q = trim($_GET['q']);
    $clients = $pdo->prepare("SELECT * FROM customers WHERE custname LIKE :name ");
    $clients->execute( array(':name' => '%' . $q . '%'));
    $result =  $clients->fetchAll();
*/