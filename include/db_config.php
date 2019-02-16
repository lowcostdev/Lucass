<?php


try {
	//$options = array(PDO::ATTR_AUTOCOMMIT=>FALSE);
	$pdo = new PDO('mysql:host=localhost;dbname=salon',"admin", "Welcone.1");
} catch (Exception $e) {
	error_log($e->getMessage());
	exit('Something weird happened'); //something a user can understand
}

?>