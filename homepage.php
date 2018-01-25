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
        $sql = "SELECT avg(count) as avg, month, day
                    FROM
                    (SELECT count(car_id) as count , DATEPART(MONTH, Ctime) as month, DATEPART(HOUR, Ctime) as hour, DATEPART(DAY, Ctime) as day
                    FROM small_drive sd
                    GROUP BY DATEPART(MONTH, Ctime), DATEPART(HOUR, Ctime), DATEPART(DAY, Ctime)) a
                    GROUP BY month, day";
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
                ['Month', 'Day', 'Use Count'],
                <?php while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
                {
                    echo "['". $row[1]."', ". $row[2] .", ".$row[0]."], ";
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

<div id="curve_chart" style="width: 900px; height: 500px"></div>
</body>
</html>
