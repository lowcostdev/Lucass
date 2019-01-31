
<?php
    
    //1st Part
    $dash12 = $pdo->prepare("SELECT SUM(ta.item_amount * item_qty) - SUM(item_disc)  + tb.other_amount as totsales, COUNT(*) as tottrans
                            FROM sales_dtl ta 
                            JOIN sales_hdr tb ON ta.invoice_no = tb.invoice_no
                                AND ta.branch_cd = tb.branch_cd
                            WHERE ta.iscancelled='N'
                                AND tb.iscancelled='N' 
                                AND DATE(tb.trandate)=DATE(NOW())");
    $dash12->execute();
    $result =  $dash12->fetch();
    $totsales =$result["totsales"] ?? 0.00;
    $tottrans =$result["tottrans"] ?? 0;
    
    $dash3 = $pdo->prepare("SELECT COUNT(*) as totcust
                            FROM (
                                SELECT *
                                FROM customers
                                WHERE MONTH(reg_date)=MONTH(NOW()) 
                                    AND YEAR(reg_date)=YEAR(NOW())
                                    AND isduplicate='N'
                                  ) ta ");
    $dash3->execute();
    $result = $dash3->fetch();
    $totcust = $result["totcust"] ?? 0;

?>

    <!-- Custom CSS -->
    <link href="css/admin.css" rel="stylesheet">
<!-- Morris Charts CSS -->
    <link href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cart-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 col-sm-9 text-right">
                                    <div class="huge"><?php echo number_format($totsales, 2); ?></div>
                                    <div>Total Sales</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-12">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-chart-bar fa-5x"></i>
                                </div>
                                <div class="col-xs-9 col-sm-9 text-right">
                                    <div class="huge"><?php echo $tottrans; ?></div>
                                    <div>&nbsp;Total Transactions</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 col-sm-9 text-right">
                                    <div class="huge"><?php echo $totcust; ?></div>
                                    <div>New Clients this month</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

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
                                                tb.customer, tc.prod_details, tb.serv_date,
                                                SUM(ta.item_amount * item_qty) - SUM(item_disc) AS totsales,
                                                tb.other_amount AS others
                                            FROM sales_dtl ta 
                                            JOIN sales_hdr tb ON ta.invoice_no = tb.invoice_no
                                                AND ta.branch_cd = tb.branch_cd
                                            LEFT JOIN product_master tc ON ta.product_id = tc.product_id
                                            WHERE ta.iscancelled='N'
                                                AND tb.iscancelled='N'
                                                AND DATE(tb.trandate)=DATE(NOW())
                                            GROUP BY CONCAT(tb.branch_cd,'-',LPAD(tb.invoice_no,8,'0'))
                                            LIMIT 8") ;
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
                                                                AND DATE(tb.trandate)=DATE(NOW())
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
