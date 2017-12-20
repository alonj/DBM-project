<html>
<head>
    <meta charset="utf-8" />
    <title>TED Stats Homepage - alonj</title>
</head>
<body>
  <link rel="stylesheet" href='styles.css' type="text/css">
  <div class="topbanner">
      <img src='hw3/ted-logo-transparent.png' class="title">
      <img src='hw3/stats.png' class="title">
      <p class="quote">Keep an eye on the popularity of TED talks, with an easy to use platform</p>
  </div>
  <div class="left">
      <ul>
          <li>Homepage<br></li>
          <li><a href="dataupload.php">Add lectures from file (.csv format)</a><br></li>
          <li><a href="singlelec.php">Add lecture (singular form)</a><br></li>
      </ul>
  </div>

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
      $sql = "SELECT Ted.name, Ted.url, (Ted.comments * 10 + Ted.views * 0.1)/Ted.duration as score
              FROM Ted";
      $result = sqlsrv_query($conn, $sql);
      echo "<br><br>";
      echo "<table style='font-family: Calibri'>";
      echo "<tr><th>Lecture Name</th><th>Popularity Score</th></tr>";
      while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
      {
         echo "<tr><td><a href='" . $row['url'] . "'>" . $row['name'] . "</a></td><td>" . $row['score']."</td></tr>";
      }
      echo "</table>";
    ?>
  <div class="middle"></div>
  <div class="right"></div>
  </body>
</html>