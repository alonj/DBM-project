<html>
  <link href="styles.css" rel="stylesheet" type="text/css">
  <body>
  <h1>Parts Table</h1>
    <table style="width: 30%">
        <tr>
            <th>ID</th>
            <th>Part Name</th>
        </tr>
        <tr>
            <td>1</td>
            <td>tv</td>
        </tr>
        <tr>
            <td>2</td>
            <td>comp</td>
        </tr>
        <tr>
            <td>3</td>
            <td>laptop</td>
        </tr>
        <tr>
            <td>4</td>
            <td>chair</td>
        </tr>
    </table>
    <?php
    $server = "tcp:dbms2016s.database.windows.net,1433";
    $user = "dbms2016s";
    $pass = "Ilovedbms2016";
    $database = "DBMS_classicmodels";
    $c = array("Database" => $database, "UID" => $user, "PWD" => $pass);
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($server, $c);
    if($conn === false)
    {
        echo "error";
        die(print_r(sqlsrv_errors(), true));
    }
      /*$sql="SELECT * FROM Parts";
      $result = sqlsrv_query($conn, $sql);
	  echo "<table border=1>"
	  echo "<th><td>ID</td><td>Part Name</td></th>"
      while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
      {
         echo "<tr><td>".$row['pid'] . "</td><td>" . $row['pname']."</td></tr>";
      }*/
	  echo "<table>"
    ?>
  </body>
</html>