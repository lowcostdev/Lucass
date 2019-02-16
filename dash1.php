<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Lukkas - Quick Sale Report</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>
<?php 
include 'include/db_config.php';
?>


        <div class="row">
            <div class="col-lg-12">
                <h4>Quick Sales</h4>
            </div>
            <div class='col-lg-12'>
               <table class="table table-bordered table-dark">
                    <thead class="thead-dark">
                        <tr>
                        <th>Tran ID</th>
                        <th>Client</th>
                        <th>Services</th>
                        <th>DATE</th>
                        <th>AMOUNT</th>
                        <th>OTHERS</th>
                        <th>TOTAL</th>
                    </tr>
                        </thead>
                    <?php
                    //2nd Part
	                    $dash4 = $pdo->prepare("SELECT CONCAT(tb.branch_cd,'-',LPAD(tb.invoice_no,8,'0')) AS tranid,
												       MAX(tb.customer) customer, MAX(tc.prod_details) prod_details, 
												       MAX(tb.serv_date) serv_date, SUM(ta.item_amount * item_qty) - SUM(item_disc) AS totsales, MAX(tb.other_amount) AS others
	                                            FROM sales_dtl ta 
	                                            JOIN sales_hdr tb ON ta.invoice_no = tb.invoice_no
	                                                AND ta.branch_cd = tb.branch_cd
	                                            LEFT JOIN product_master tc ON ta.product_id = tc.product_id
	                                            WHERE ta.iscancelled='N'
	                                                AND tb.iscancelled='N'
	                                                AND DATE(tb.trandate)=DATE(NOW())
	                                                -- AND MONTH(tb.trandate)=MONTH(NOW())
	                                                -- AND YEAR(tb.trandate)=YEAR(NOW())                                                 
	                                            GROUP BY CONCAT(tb.branch_cd,'-',LPAD(tb.invoice_no,8,'0'))") ;
                    $dash4->execute();
                    $result = $dash4->fetchAll();


                    $services = '';
                    $count = 0;
                    foreach($result as $row) {                     
                        $tranid = $row["tranid"];
                        $customer = $row["customer"];
                        $serv_date = $row["serv_date"];
                        $totsales = ($row["totsales"] * 1); 
                        $others = $row["others"];

                        echo "<tr>
                              <td>$tranid</td> 
                              <td>$customer</td>
                              <td>";
                                    $dash5 = $pdo->prepare("SELECT CONCAT(tb.branch_cd,'-',LPAD(tb.invoice_no,8,'0')) AS tranid,
                                                                tb.customer, tc.prod_details, tb.serv_date,
                                                                SUM(ta.item_amount * item_qty) - SUM(item_disc) + tb.other_amount AS totsales
                                                            FROM sales_dtl ta 
                                                            JOIN sales_hdr tb ON ta.invoice_no = tb.invoice_no
                                                                AND ta.branch_cd = tb.branch_cd
                                                            LEFT JOIN product_master tc ON ta.product_id = tc.product_id
                                                            WHERE ta.iscancelled='N'
                                                                AND tb.iscancelled='N'
				                                                AND MONTH(tb.trandate)=MONTH(NOW())
				                                                AND YEAR(tb.trandate)=YEAR(NOW())
                                                                AND  CONCAT(tb.branch_cd,'-',LPAD(tb.invoice_no,8,'0')) = :tranid
                                                            GROUP BY CONCAT(tb.branch_cd,'-',LPAD(tb.invoice_no,8,'0')), ta.product_id");
                                    $dash5->execute(array(':tranid' => $tranid));
                                    $res = $dash5->fetchAll();
                                    foreach($res as $row1) {            
                                        echo $row1["prod_details"] ."<br/>";
                                    }
                        echo "</td>
                              <td>$serv_date</td> 
                              <td>". number_format($totsales, 2) . "</td>
                              <td>". number_format($others, 2) . "</td>
                              <td>". number_format($totsales + $others, 2) . "</td>
                              </tr>";                

                    } 


                    ?>
                </table>
            </div>
        </div>
