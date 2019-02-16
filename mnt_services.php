<?php
include 'include/db_config.php';
include 'include/funcs.php';

$prod_id = $_GET["prod_id"] ?? "";
$branch_cd = $_GET["branch_cd"] ?? "";
$serv_tag = $_GET["serv_tag"] ?? "";

$product = $pdo->prepare("SELECT * FROM product_master WHERE product_id = :prod_id ");
$product->execute( array(':prod_id' => $prod_id));
$result =  $product->fetch();

echo "<p><h2>$result[prod_details]</h2>";


if(isset($_POST["submit"])) {
	$pdo->beginTransaction(); 
	if($_POST["prod_id"]=="") {
		$nextProdNo = get_nextNo_Service($_POST["branch_cd"]);
		$insert = $pdo->prepare("INSERT INTO product_master 
										(product_id, prod_details, amount, commission, startdate, enddate, remarks, branch_cd, serv_tag) 
						         VALUES (:prod_id, :prod_details, :amount, :commission, :startdate, :enddate, :remarks,
						         		 :branch_cd, :serv_tag)");
		$insert->execute(array (':prod_id' => str_pad($nextProdNo,10,"0", STR_PAD_LEFT),
								':prod_details' => $_POST["prod_details"],
								':amount' => $_POST["amount"],
								':commission' => $_POST["commission"],
								':startdate' => date("Y-m-d", strtotime($_POST["startdate"])),
								':enddate' => ($_POST["enddate"]=="") ? null : date("Y-m-d", strtotime($_POST["enddate"])),
								':remarks' => $_POST["remarks"],
								':branch_cd' => $_POST["branch_cd"],
								':serv_tag' => $_POST["serv_tag"]
								)
						);
	
	} else {
		$update = $pdo->prepare("UPDATE product_master 
						         SET prod_details = :prod_details,
						         	amount = :amount,
						         	commission = :commission,
						         	startdate = :startdate,
						         	enddate = :enddate,
						         	remarks = :remarks
						         WHERE product_id = :prod_id");
		$update->execute(array (':prod_details' => $_POST["prod_details"],
								':amount' => $_POST["amount"],
								':commission' => $_POST["commission"],
								':startdate' => date("Y-m-d", strtotime($_POST["startdate"])),
								':enddate' => ($_POST["enddate"]=="") ? null : date("Y-m-d", strtotime($_POST["enddate"])),
								':remarks' => $_POST["remarks"],
								':prod_id' => $_POST["prod_id"]
								)
						);
	}
	
	if($pdo->commit()) {
		echo "<script>
		          alert('Transaction Successful!');
		          window.opener.location.reload();
		          self.close();
		       </script>";
        exit();
	}

}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Lukkas - Product/ Services</title>
    <style type="text/css">
    input[type=number] { 
    	text-align: right; 
	}
    </style>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script>
	$( function() {
		$( "#startdate" ).datepicker();
		$( "#enddate" ).datepicker();
  	} );
</script>
</head>
<body>

<?php

$prod_details = $result['prod_details'];
$amount = $result['amount'];
$commission = $result['commission'];
$startdate = $result['startdate'];
$enddate = $result['enddate'];
$remarks = $result['remarks'];
$trandate = $result['trandate'];

?>
<form method="post" id="insert_form" method="POST" action="mnt_services.php">
	<table class="table">
		<tr>
			<td>Product</td>
			<td>:</td>
			<td><input type="text" class="form-group" name="prod_details" value="<?php echo $prod_details; ?>"></td>
		</tr>
		<tr>
			<td>Amount</td>
			<td>:</td>
			<td><input type="number" class="form-group" name="amount" value="<?php echo $amount; ?>"></td>
		</tr>
		<tr>
			<td>Default Comm</td>
			<td>:</td>
			<td><input type="number" class="form-group" name="commission" value="<?php echo $commission; ?>"></td>
		</tr>
		<tr>
			<td>Start Date</td>
			<td>:</td>
			<td>
				<input type="text" id="startdate"  name="startdate" class="form-group" value="<?php echo $startdate; ?>">
			</td>
		</tr>
		<tr>
			<td>End Date</td>
			<td>:</td>
			<td>
				<input type="text" id="enddate"  name="enddate" class="form-group" value="<?php echo $enddate; ?>">
			</td>
		</tr>
		<tr>
			<td>Remarks</td>
			<td>:</td>
			<td><input type="text" class="form-group" name="remarks" value="<?php echo $remarks; ?>"></td>
		</tr>
		<tr>
			<td>Registered Date</td>
			<td>:</td>
			<td><?php echo $trandate; ?></td>
		</tr>		
		<tr>
			<td>
				<input type="hidden" value="<?php echo $prod_id; ?>" name="prod_id">
				<input type="hidden" value="<?php echo $branch_cd; ?>" name="branch_cd">
				<input type="hidden" value="<?php echo $serv_tag; ?>" name="serv_tag">
				<button type="submit" class="btn btn-default" name="submit">Update</button>
			</td>
		</tr>
	</table>
</form>
</body>
</html>