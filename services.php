<?php
	$serv_tag = ($_GET['serv_tag']==1 ) ? "Services" : "Products";
	//echo "<h1>$serv_tag</h1>";
    $clients = $pdo->prepare("SELECT * FROM product_master WHERE serv_tag = :serv_tag AND branch_cd = :branch_cd");
    $clients->execute( array( ':serv_tag' => $_GET["serv_tag"],
    						  ':branch_cd' => $branch_cd
							)
					  );
    $result =  $clients->fetchAll();
?>
 <div class="row">
	<div class="col-lg-12">
    	<h1 class="page-header"><?php echo $serv_tag; ?></h1>
    </div>
                <!-- /.col-lg-12 -->
</div>

<div class="table-repsonsive">
	<table class="table">
		<tr>
			<th>ID</th>
			<th>Product/Service</th>
			<th>Cost</th>
			<th>Comm</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Remarks</th>
			<th></th>
		</tr>
		<?php
		foreach($result as $rows) {
			echo "<tr onclick=\"window.open('mnt_services.php?prod_id=$rows[product_id]', 'New Form','width=500,height=400,scroll=auto')\">
				      <td>$rows[product_id]</td>
				      <td>$rows[prod_details]</td>
				      <td>$rows[amount]</td>
				      <td>$rows[commission]</td>
				      <td>$rows[startdate]</td>
				      <td>$rows[enddate]</td>
				      <td>$rows[remarks]</td>
				      <td>$rows[trandate]</td>
				  </tr>";
		}

		?>
	</table>
	<button onclick="window.open('mnt_services.php?serv_tag=<?php echo $serv_tag; ?>&branch_cd=<?php echo $branch_cd;?>','New Form','width=500,height=400,scroll=auto');">Add New</button>
</div>