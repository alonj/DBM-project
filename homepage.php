<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
    <?php
        /**
         * Created by PhpStorm.
         * User: alonj
         * Date: 20-Jan-18
         * Time: 15:51
         */
        $server = "tcp:techniondbcourse01.database.windows.net,1433";
        $c = array("Database" => "dbstudents", "UID" => "dbstudents", "PWD" => "Qwerty12!");
        sqlsrv_configure('WarningsReturnAsErrors', 0);
        $conn = sqlsrv_connect($server, $c);
        if($conn === false)
        {
            echo '<script language = "javascript">';
            echo 'alert("Connection to database failed!")';
            echo '</script>';
            die(print_r(sqlsrv_errors(), true));
        }
        $sql = "SELECT dbstudents.dbo.small_drive.car_id, dbstudents.dbo.small_drive.Ctime
              FROM dbstudents.dbo.small_drive
              ";
        $result = sqlsrv_query($conn, $sql);
        echo "<br><br>";
        echo "<table style='font-family: Calibri'>";
        echo "<tr>";
        echo "<th>Car ID</th>";
        echo "<th>Time recorded</th>";
        echo "</tr>";
        while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
        {
          echo "<tr>";
          echo "<td>" . $row['car_id']        ."</td>";
          echo "<td>" . $row['Ctime']       ."</td>";
          echo"</tr>";
        }
        echo "</table>";
    ?>
</body>
</html>
