<?php session_start(); ?>
<html>
<head>
    <meta charset="utf-8" />
    <title>New York - Public Transportation</title>
</head>
<body>
<?php
$_SESSION["server"] = "tcp:techniondbcourse01.database.windows.net,1433";
$_SESSION["c"] = array("Database" => "dbstudents", "UID" => "dbstudents", "PWD" => "Qwerty12!");
?>
  <link rel="stylesheet" href='styles.css' type="text/css">
  <div class="topbanner">
      <img height="61px" width="100px" src="https://static-assets.ny.gov/sites/all/themes/ny_gov/images/logo_footer.png" class="title" alt="New York - Public Transportation Information">
      <p class="quote">Public Transportation Information</p>
  </div>
  <div class="left">
      <ul>
          <li><a href="homepage.php" target="center_frame">Homepage</a><br></li>
          <li><a href="singleform.php" target="center_frame">Add driver (singular form)</a><br></li>
          <li><a href="fileform.php" target="center_frame">Add ride details from file<br>(.csv format)</a><br></li>
          <li><a href="heatmap.php" target="center_frame">New York Heatmap</a><br></li>
      </ul>
  </div>
  <div class="middle">
    <iframe name="center_frame" src = "homepage.php" width="100%" height="100%" scrolling=
        <?php if(basename($_SERVER['PHP_SELF'])!="homepage.php"){echo "no";} ?>></iframe>
  </div>
  </body>
</html>

