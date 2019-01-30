<?php
    include 'include/db_config.php';

if(isset($_POST['search'])){
    $search = $_POST['search'];

    $clients = $pdo->prepare("SELECT * FROM customers WHERE cust_name LIKE :name ");
    $clients->execute( array(':name' => '%' . $search . '%'));
    $result =  $clients->fetchAll();


    foreach($result as $row ){
        $response[] = array("value"=>$row['cust_id'],"label"=>$row['cust_name']);
    }

    echo json_encode($response);
}

exit;


