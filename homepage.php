<?php session_start(); ?>
<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
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
        $sql = "SELECT driver_id, hobby
                FROM driver";
        $result = sqlsrv_query($conn, $sql);
        if( $result === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        echo "<br><br>";
        echo "<table style='font-family: Calibri'>";
        echo "<tr>";
        echo "<th>Car ID</th>";
        echo "<th>Time recorded</th>";
        echo "</tr>";
        while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
        {
          echo "<tr>";
          echo "<td>" . $row['driver_id']        ."</td>";
          echo "<td>" . $row['hobby']            ."</td>";
          echo"</tr>";
        }
        echo "</table>";
    ?>
</body>
</html>
