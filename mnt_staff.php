<?php
include 'include/db_config.php';
include 'include/funcs.php';

$staff_id = $_GET["staff_id"] ?? "";
$branch_cd = $_GET["branch_cd"] ?? "";

$staff = $pdo->prepare("SELECT *, 
							CONCAT(emp_fname,' ', emp_sname, ', ', emp_mname) AS staffname,
	    					concat(addr1,' ', addr2) as address
    					FROM employee_master
    					WHERE specialist_id = :staff_id ");
$staff->execute( array(':staff_id' => $staff_id));
$result =  $staff->fetch();

echo "<p><h2>$result[staffname]</h2>";


if(isset($_POST["submit"])) {
	$pdo->beginTransaction(); 
	if($_POST["staff_id"]=="") {
		$nextStaffNo = get_nextNo_Staff($_POST["branch_cd"]);
		$insert = $pdo->prepare("INSERT INTO employee_master 
										(specialist_id, emp_fname, emp_sname, emp_mname, bdate, addr1, addr2, contact_details, 
										hire_date, isactive, branch_cd) 
						         VALUES (:staff_id, :emp_fname, :emp_sname, :emp_mname, :bdate, :addr1, :addr2, :contact_details, :hire_date, 
						         		 :isactive, :branch_cd)");
		$insert->execute(array (':staff_id' => str_pad($nextStaffNo,10,"0", STR_PAD_LEFT),
								':emp_fname' => $_POST["emp_fname"],
								':emp_sname' => $_POST["emp_sname"],
								':emp_mname' => $_POST["emp_mname"],
								':bdate' => date("Y-m-d", strtotime($_POST["bdate"])),
								':addr1' => $_POST["addr1"],
								':addr2' => $_POST["addr2"],
								':contact_details' => $_POST["contacts"],
								':hire_date' => date("Y-m-d", strtotime($_POST["hire_date"])),
								':isactive' => $_POST["isactive"], 
								':branch_cd' => $_POST["branch_cd"]
								)
						);
	} else {
		$update = $pdo->prepare("UPDATE employee_master 
						         SET emp_fname = :emp_fname,
						         	emp_sname = :emp_sname,
						         	emp_mname = :emp_mname,
									bdate = :bdate,
						         	addr1 = :addr1,
						         	addr2 = :addr2,
						         	contact_details = :contact_details,
						         	hire_date = :hire_date,
						         	isactive = :isactive
						         WHERE specialist_id = :staff_id 
						         	   AND  branch_cd = :branch_cd");
		$update->execute( array(':emp_fname' => $_POST["emp_fname"],
								':emp_sname' => $_POST["emp_sname"],
								':emp_mname' => $_POST["emp_mname"],
								':bdate' => date("Y-m-d", strtotime($_POST["bdate"])),
								':addr1' => $_POST["addr1"],
								':addr2' => $_POST["addr2"],
								':contact_details' => $_POST["contacts"],
								':hire_date' => date("Y-m-d", strtotime($_POST["hire_date"])),
								':isactive' => $_POST["isactive"], 
								':staff_id' => $_POST["staff_id"],
								':branch_cd' => $_POST["branch_cd"]
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

    <title>Lukkas - Crew</title>
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
		$( "#bdate" ).datepicker();
		$( "#hire_date" ).datepicker();
  	} );
</script>
</head>
<body>

<?php

$staff_id = $result['specialist_id'];
$emp_sname = $result['emp_sname'];
$emp_fname = $result['emp_fname'];
$emp_mname = $result['emp_mname'];
$bdate = $result['bdate'];
$addr1 = $result['addr1'];
$addr2 = $result['addr2'];
$contacts = $result['contact_details'];
$hire_date = $result['hire_date'];
$isactive = $result['isactive'];

?>
<form method="post" id="insert_form" method="POST" action="mnt_staff.php">
	<table class="table">
		<tr>
			<td>Surname</td>
			<td>:</td>
			<td><input type="text" class="form-group" name="emp_sname" value="<?php echo $emp_sname; ?>"></td>
		</tr>
		<tr>
			<td>First Name</td>
			<td>:</td>
			<td><input type="text" class="form-group" name="emp_fname" value="<?php echo $emp_fname; ?>"></td>
		</tr>
		<tr>
			<td>Middle Name</td>
			<td>:</td>
			<td><input type="text" class="form-group" name="emp_mname" value="<?php echo $emp_mname; ?>"></td>
		</tr>
		<tr>
			<td>Birth Date</td>
			<td>:</td>
			<td>
				<input type="text" id="bdate"  name="bdate" class="form-group" value="<?php echo $bdate; ?>">
			</td>
		</tr>
		<tr>
			<td>Address1</td>
			<td>:</td>
			<td>
				<input type="text" name="addr1" class="form-group" value="<?php echo $addr1; ?>">
			</td>
		</tr>
		<tr>
			<td>Address2</td>
			<td>:</td>
			<td>
				<input type="text" name="addr2" class="form-group" value="<?php echo $addr2; ?>">
			</td>
		</tr>
		<tr>
			<td>Contact Details</td>
			<td>:</td>
			<td>
				<input type="text" name="contacts" class="form-group" value="<?php echo $contacts; ?>">
			</td>
		</tr>
		<tr>
			<td>Date Hired</td>
			<td>:</td>
			<td>
				<input type="text" id="hire_date"  name="hire_date" class="form-group" value="<?php echo $hire_date; ?>">
			</td>
		</tr>
		<tr>
			<td>Active</td>
			<td>:</td>
			<td>
				<select name="isactive">
					<?php echo "<option value=$isactive selected>$isactive</option>"; ?>
					<option value="Y">Y</option>
					<option value="N">N</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" value="<?php echo $staff_id; ?>" name="staff_id">
				<input type="hidden" value="<?php echo $branch_cd; ?>" name="branch_cd">
				<button type="submit" class="btn btn-default" name="submit">Update</button>
			</td>
		</tr>
	</table>
</form>
</body>
</html>