<?php
include 'include/db_config.php';


                    $serv1 = $pdo->prepare("SELECT ta.months, tb.*
                                            FROM help_months ta
                                            LEFT JOIN 
                                                (
                                                SELECT MONTH(tb.trandate) months, COUNT(*) AS trans,
                                                        (SUM(ta.item_amount * item_qty) - SUM(item_disc)) 
                                                        + MAX(tb.other_amount) AS totsales
                                                FROM sales_dtl ta 
                                                JOIN sales_hdr tb
                                                     ON ta.invoice_no = tb.invoice_no AND ta.branch_cd = tb.branch_cd
                                                LEFT JOIN product_master tc 
                                                    ON ta.product_id = tc.product_id
                                                WHERE ta.iscancelled='N'
                                                      AND tb.iscancelled='N'
                                                      --     AND MONTH(tb.trandate)=MONTH(NOW())
                                                      AND YEAR(tb.trandate)=YEAR(NOW())
                                                      AND tc.serv_tag = 1
                                                GROUP BY MONTH(tb.trandate)
                                                ) tb ON ta.months = tb.months");
                    $serv1->execute();
                    $res1 = $serv1->fetchAll();


                    $serv2 = $pdo->prepare("SELECT ta.months, tb.*
                                            FROM help_months ta
                                            LEFT JOIN 
                                                (
                                                SELECT MONTH(tb.trandate) months, COUNT(*) AS trans,
                                                        (SUM(ta.item_amount * item_qty) - SUM(item_disc)) 
                                                        + MAX(tb.other_amount) AS totsales
                                                FROM sales_dtl ta 
                                                JOIN sales_hdr tb
                                                     ON ta.invoice_no = tb.invoice_no AND ta.branch_cd = tb.branch_cd
                                                LEFT JOIN product_master tc 
                                                    ON ta.product_id = tc.product_id 
                                                WHERE ta.iscancelled='N'
                                                      AND tb.iscancelled='N'
                                                      --     AND MONTH(tb.trandate)=MONTH(NOW())
                                                      AND YEAR(tb.trandate)=YEAR(NOW())      
                                                      AND tc.serv_tag = 2
                                                GROUP BY MONTH(tb.trandate)
                                                ) tb ON ta.months = tb.months");
                    $serv2->execute();
                    $res2 = $serv2->fetchAll();

?>

    <script src="https://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script>
    <script src="https://www.chartjs.org/samples/latest/utils.js"></script>

    <style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>

        <script>
        var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var config = {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Services',
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                       <?php

                        foreach($res1 as $row1) {                     
                            echo $row1["totsales"] . ",";
                        }
                        
                       ?>     
                    ],
                    fill: false,
                }, {
                    label: 'Inventory',
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                       <?php

                        foreach($res2 as $row2) {                     
                            echo $row2["totsales"] . ",";
                        }
                        
                       ?>     
                    ],
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Annual Line Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById('linechart').getContext('2d');
            window.myLine = new Chart(ctx, config);
        };
    </script>
