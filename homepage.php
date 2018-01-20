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
  $sql = "SELECT dID, name, hobby, address, d_birth
          FROM project.Driver";
  $result = sqlsrv_query($conn, $sql);
  echo "<br><br>";
  echo "<table style='font-family: Calibri'>";
  echo "<tr>
            <th>Driver ID</th>
            <th>Name</th>
            <th>Hobby</th>
            <th>Address</th>
            <th>Date of Birth</th>
        </tr>";
  while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
  {
      echo "<tr><td>" . $row['dID'] .   "</td>
                <td>" . $row['name'].   "</td>
                <td>" . $row['hobby'].  "</td>
                <td>" . $row['address']."</td>
                <td>" . $row['d_birth']."</td>
            </tr>";
  }
  echo "</table>";