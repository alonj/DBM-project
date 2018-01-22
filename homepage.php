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
$c = array("Database" => "alonj", "UID" => "alonj", "PWD" => "Qwerty12!");
sqlsrv_configure('WarningsReturnAsErrors', 0);
$conn = sqlsrv_connect($server, $c);
if($conn === false)
{
    echo '<script language = "javascript">';
    echo 'alert("Connection to database failed!")';
    echo '</script>';
    die(print_r(sqlsrv_errors(), true));
}
  $sql = "SELECT project.RideP.rID, project.RideP.time, project.RideP.latitude, project.RideP.longitude, project.RideP.base
          FROM project.RideP
          WHERE project.RideP.base = 'B02617'";
  $result = sqlsrv_query($conn, $sql);
  echo "<br><br>";
  echo "<table style='font-family: Calibri'>";
  echo "<tr>";
  echo "<th>Ride index</th>";
  echo "<th>Time recorded</th>";
  echo "<th>latitude</th>";
  echo "<th>longitude</th>";
  echo "<th>Base</th>";
  echo "</tr>";
  while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
  {
      echo "<tr>";
      echo "<td>" . $row['rID'] .       "</td>";
      echo "<td>" . $row['time'].       "</td>";
      echo "<td>" . $row['latitude'].   "</td>";
      echo "<td>" . $row['longitude'].  "</td>";
      echo "<td>" . $row['base'].       "</td>";
      echo"</tr>";
  }
  echo "</table>";
  ?>
</body>
</html>
