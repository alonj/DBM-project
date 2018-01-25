<?php
session_start();
?>
<html>
<head>
    <?php
        sqlsrv_configure('WarningsReturnAsErrors', 0);
        $conn = sqlsrv_connect($_SESSION["server"], $_SESSION["c"]);
        if($conn === false)
        {
            echo '<script language = "javascript">';
                echo 'alert("Connection to database failed!")';
                echo '</script>';
            die(print_r(sqlsrv_errors(), true));
        }
        $sql = "SELECT avg(count) as avg, month
                    FROM
                      (SELECT count(car_id) as count , DATEPART(MONTH, Ctime) as month, DATEPART(HOUR, Ctime) as hour
                       FROM small_drive sd
                       GROUP BY DATEPART(MONTH, Ctime), DATEPART(HOUR, Ctime), DATEPART(DAY, Ctime)) a
                    GROUP BY month
                    ORDER BY month";
        $result = sqlsrv_query($conn, $sql);
        if( $result === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Use Count'],
                <?php while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
                {
                    echo "['". $row['month']."', ". $row['avg'] ."], ";
                }?>
            ]);

            var options = {
                title: 'Hourly Average, over time',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
<p class="quote" style="font-weight: bold;
                        font-size: 16px;
                        color: #0B5584;
                        font-family: 'D Sari Bold', Calibri, sans-serif;
                        text-align: center;"> Below, tracking the average hourly usage (number of rides recorded), per month, over time.</p><br>
<div id="curve_chart" style="width: 900px; height: 500px"></div>
<p class="quote" style="font-weight: bold;
                        font-size: 16px;
                        color: #0B5584;
                        font-family: 'D Sari Bold', Calibri, sans-serif;
                        text-align: center;"> Note, the data will become more significant as it grows.</p><br>
</body>
</html>
