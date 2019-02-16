<?php
    $staff = $pdo->prepare("SELECT *, 
    							   concat(emp_fname,' ', emp_mname) as names,
    							   concat(addr1,' ', addr2) as address
    						FROM employee_master 
    						WHERE branch_cd = :branch_cd");

    $staff->execute( array( ':branch_cd' => $branch_cd
							)
					  );
    $result =  $staff->fetchAll();
?>
 <div class="row">
	<div class="col-lg-12">
    	<h1 class="page-header">The Crew</h1>
    </div>
                <!-- /.col-lg-12 -->
</div>

<div class="table-repsonsive">
	<table class="table">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Bdate</th>
			<th>Address</th>
			<th>Contact No</th>
			<th>Date hired</th>
			<th>Active Tag</th>
		</tr>
		<?php
		foreach($result as $rows) {
			echo "<tr onclick=\"window.open('mnt_staff.php?staff_id=$rows[specialist_id]&branch_cd=$branch_cd', 'New Form','width=700,height=400,scroll=auto')\">
				      <td>$rows[specialist_id]</td>
				      <td>$rows[names]</td>
				      <td>$rows[bdate]</td>
				      <td>$rows[address]</td>
				      <td>$rows[contact_details]</td>
				      <td>$rows[hire_date]</td>
				      <td>$rows[isactive]</td>
				  </tr>";
		}

		?>
	</table>
	<button onclick="window.open('mnt_staff.php?branch_cd=<?php echo $branch_cd;?>','New Form','width=500,height=400,scroll=auto');">Add New</button>
</div>