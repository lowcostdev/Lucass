<?php

include 'include/db_config.php';

$cust_id = $_GET["cust_id"] ?? "";


$clients = $pdo->prepare("SELECT * FROM customers WHERE cust_id = :cust_id ");
$clients->execute( array(':cust_id' => $cust_id));
$result =  $clients->fetch();

echo $result['cust_name'];


if(isset($_POST["submit"])) {
	$pdo->beginTransaction(); 
	$update = $pdo->prepare("UPDATE customers 
					         SET cust_name = :cust_name,
					         	bdate =:bdate,
					         	cust_address = :cust_address,
					         	cust_city = :cust_city,
					         	mobileno = :mobileno
					         WHERE cust_id = :cust_id");
	$update->execute(array (':cust_name' => $_POST["cust_name"],
							':bdate' => date("Y-m-d", strtotime($_POST["bdate"])),
							':cust_address' => $_POST["cust_address"],
							':cust_city' => $_POST["cust_city"],
							':mobileno' => $_POST["mobileno"],
							':cust_id' => $_POST["cust_id"]));

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

    <title>Lukkas - Clients</title>

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
		$( "#datebdate" ).datepicker();
  	} );
</script>
</head>
<body>

<form method="post" id="insert_form" method="POST" action="mnt_clients.php">
	<table class="table">
		<tr>
			<td>Customer Name</td>
			<td>:</td>
			<td><input type="text" class="form-group" name="cust_name" value="<?php echo $result['cust_name']; ?>"></td>
		</tr>
		<tr>
			<td>Birth date</td>
			<td>:</td>
			<td><input type="text" id="datebdate"  name="bdate" class="form-group" value="<?php echo $result['bdate']; ?>"></td>
		</tr>
		<tr>
			<td>Address</td>
			<td>:</td>
			<td><input type="text" class="form-group" name="cust_address" value="<?php echo $result['cust_address']; ?>"></td>
		</tr>
		<tr>
			<td>City</td>
			<td>:</td>
			<td><input type="text" class="form-group" name="cust_city" value="<?php echo $result['cust_city']; ?>"></td>
		</tr>
		<tr>
			<td>Contact Nos.</td>
			<td>:</td>
			<td><input type="text" class="form-group" name="mobileno" value="<?php echo $result['mobileno']; ?>"></td>
		</tr>
		<tr>
			<td>Registered Date</td>
			<td>:</td>
			<td><?php echo $result['reg_date']; ?></td>
		</tr>		
		<tr>
			<td>
				<input type="hidden" value="<?php echo $cust_id; ?>" name="cust_id">
				<button type="submit" class="btn btn-default" name="submit">Update</button>
			</td>
		</tr>
	</table>
</form>
</body>
</html>