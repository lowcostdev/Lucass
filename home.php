
<?php
    
    //1st Part
    $dash12 = $pdo->prepare("SELECT SUM(ta.item_amount * item_qty) - SUM(item_disc)  + MAX(tb.other_amount) as totsales, 
                                    COUNT(*) as tottrans
                            FROM sales_dtl ta 
                            JOIN sales_hdr tb ON ta.invoice_no = tb.invoice_no
                                 AND ta.branch_cd = tb.branch_cd
                            WHERE ta.iscancelled='N'
                                AND tb.iscancelled='N' 
                                AND DATE(tb.trandate)=DATE(NOW())
                                AND tb.branch_cd = :branch_cd ");
    $dash12->execute(array(':branch_cd'=>$branch_cd));
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
                                    <div>Earnings (Daily)</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" onclick="window.open('dash1.php','_blank');">
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
                                    <div>&nbsp;Total Transactions (Daily)</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" onclick="window.open('dash1.php','_blank');">
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
                <div class="col-lg-10 col-md-10">
                    <canvas id="linechart"></canvas>
                </div>

            </div>
        </div>


<?php
include 'line_chart.php';
?>