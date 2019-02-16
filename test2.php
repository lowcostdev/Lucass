<?php
$dash5 = $pdo->prepare("SELECT tc.prod_details, COUNT(*) AS trans,
                               (SUM(ta.item_amount * item_qty) - SUM(item_disc)) + MAX(tb.other_amount) AS totsales
                        FROM sales_dtl ta 
                        JOIN sales_hdr tb ON ta.invoice_no = tb.invoice_no
                                AND ta.branch_cd = tb.branch_cd
                        LEFT JOIN product_master tc ON ta.product_id = tc.product_id and ta.branch_cd = tc.branch_cd
                        WHERE ta.iscancelled='N'
                                AND tb.iscancelled='N'
                                AND MONTH(tb.trandate)=MONTH(NOW())
                                AND YEAR(tb.trandate)=YEAR(NOW())
                                AND tb.branch_cd = :branch_cd
                        GROUP BY prod_details");
$dash5->execute( array(':branch_cd' => $branch_cd));

$result = $dash5->fetchAll();
?>

    <script src="https://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script>
    <script src="https://www.chartjs.org/samples/latest/utils.js"></script>

    <div id="canvas-holder" style="width:100%">
        <canvas id="chart-area"></canvas>
    </div>
    <script>
        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100);
        };

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                       <?php

                        foreach($result as $row) {                     
                            echo $row["totsales"] . ",";
                        }
                       ?>     
                    ],
                    backgroundColor: [
                        window.chartColors.red,
                        window.chartColors.orange,
                        window.chartColors.yellow,
                        window.chartColors.green,
                        window.chartColors.blue,
                        window.chartColors.pink,
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                <?php
                    $numitems = count($result);
                    $i = 0;
                    foreach($result as $row) {
                        if($i==$numitems) {
                               echo "'".$row["prod_details"] . "'";
                        } else {
                               echo "'".$row["prod_details"] . "',";
                        }
                    }

                ?>

                ]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Month Sales'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById('chart-area').getContext('2d');
            window.myDoughnut = new Chart(ctx, config);
        };

        document.getElementById('randomizeData').addEventListener('click', function() {
            config.data.datasets.forEach(function(dataset) {
                dataset.data = dataset.data.map(function() {
                    return randomScalingFactor();
                });
            });

            window.myDoughnut.update();
        });


    </script>
