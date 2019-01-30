<?php
include '../include/db_config.php';

if(isset($_POST["product_id"])) {
	if($_POST["product_id"] != '') {
		$stmt = $pdo->prepare("SELECT amount FROM product_master WHERE product_id = :prodid");
		$stmt->bindParam(':prodid', $_POST["product_id"]);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//echo "<input class='form-control input-sm' name='txtAmount' id='amount' value=$row[amount] readonly=readonly>";
			echo $row["amount"];
		}
	} else {
		echo "0.00";
	}
} else {
	echo "0.00";
}



?>