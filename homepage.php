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
    echo 'alert("Update failure!")';
    echo '</script>';
    die(print_r(sqlsrv_errors(), true));
}
  $sql = "SELECT rID, time, latitude, longitude, base
          FROM project.RideP";
  $result = sqlsrv_query($conn, $sql);
  echo "<br><br>";
  echo "<table style='font-family: Calibri'>";
  echo "<tr>
            <th>Ride index</th>
            <th>Time recorded</th>
            <th>latitude</th>
            <th>longitude</th>
            <th>Base</th>
        </tr>";
  while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
  {
      echo "<tr><td>" . $row['rID'] .   "</td>
                <td>" . $row['time'].   "</td>
                <td>" . $row['latitude'].  "</td>
                <td>" . $row['longitude']."</td>
                <td>" . $row['base']."</td>
            </tr>";
  }
  echo "</table>";