<?php

    $clients = $pdo->prepare("SELECT * FROM customers ORDER BY cust_name");
    $clients->execute();
    $result =  $clients->fetchAll();
?>
 <div class="row">
	<div class="col-lg-12">
    	<h1 class="page-header">Customers</h1>
    </div>
                <!-- /.col-lg-12 -->
</div>

<div class="table-repsonsive">
	<table class="table">
		<tr>
			<th>ID</th>
			<th>Customer</th>
			<th>BDATE</th>
			<th>ADDRESS</th>
			<th>CITY</th>
			<th>CONTACT NO</th>
		</tr>
		<?php
		foreach($result as $rows) {
			echo "<tr onclick=\"window.open('mnt_clients.php?cust_id=$rows[cust_id]', 'New Form','width=500,height=400,scroll=auto')\">
				      <td>$rows[cust_id]</td>
				      <td>$rows[cust_name]</td>
				      <td>$rows[bdate]</td>
				      <td>$rows[cust_address]</td>
				      <td>$rows[cust_city]</td>
				      <td>$rows[mobileno]</td>
				  </tr>";
		}

		?>
	</table>
</div>