<?php
    include 'include/db_config.php';

if(isset($_POST['search'])){
    $search = $_POST['search'];

    $clients = $pdo->prepare("SELECT * FROM customers WHERE cust_name LIKE :name GROUP BY cust_name");
    $clients->execute( array(':name' => '%' . $search . '%'));
    $result =  $clients->fetchAll();


    foreach($result as $row ){
        $response[] = array("value"=>$row['cust_id'],"label"=>$row['cust_name']);
    }

//    if(count($response)==0) {
//    	$response[] = "";
//        $response[] = array("value"=>"-","label"=>"-");
//    }
    if(count($response)) {
    	echo json_encode($response);	
    } else {
    	$response1 = count($response);
    	$response2[] = array("value"=>"","label"=>"");
    	echo json_encode($response);	
	}    
}

exit;