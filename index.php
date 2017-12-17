<html>
<body>
  <title>TED Stats Homepage - alonj</title>
  <link href="styles.css" rel="stylesheet" type="text/css">
  <img src="hw3/ted-logo-transparent.png" class="title">
  <img src="hw3/stats.png" class="title">
  <p class="quote">Keep an eye on the popularity of TED talks, with an easy to use platform</p>
  <a href="dataupload.php">Add lectures from file (.csv format)</a><br>
  <a href="singlelec.php">Add lecture (singular form)</a>
    <?php
    $server = "tcp:techniondbcourse01.database.windows.net,1433";
    $c = array("Database" => "alonj", "UID" => "alonj", "PWD" => "Qwerty12!");
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($server, $c);
    if($conn === false)
    {
        echo "error";
        die(print_r(sqlsrv_errors(), true));
    }
      $sql = "SELECT name, (10*comments + 0.1*views)/duration as score  
              FROM Ted";
      $result = sqlsrv_query($conn, $sql);
      echo "<table border=1>";
      echo "<th><td>Lecture Name</td><td>Score</td></th>";
      while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
      {
         echo "<tr><td>".$row['name'] . "</td><td>" . $row['score']."</td></tr>";
      }
      echo "<table>"
    ?>
  </body>
</html>