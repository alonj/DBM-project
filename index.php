<html>
<head>
    <meta charset="utf-8" />
    <title>New York - Public Transportation</title>
</head>
<body>
  <link rel="stylesheet" href='styles.css' type="text/css">
  <div class="topbanner">
      <img src='hw3/ted-logo-transparent.png' class="title" alt="New York - Public Transportation Information"> <!--TODO add some nice header image-->
      <p class="quote">Keep an eye on the popularity of TED talks, with an easy to use platform</p>
  </div>
  <div class="left">
      <ul>
          <li><a href="homepage.php" target="center_frame">Homepage</a><br></li>
          <li><a href="singleform.php" target="center_frame">Add driver (singular form)</a><br></li>
          <li><a href="fileform.php" target="center_frame">Add ride details from file (.csv format)</a><br></li>
          <li><a href="heatmap.php" target="center_frame">New York Heatmap</a><br></li>
      </ul>
  </div>
  <div class="middle">
    <iframe name="center_frame" src = "homepage.php" width="100%" height="100%" scrolling=
        <?php if(basename($_SERVER['PHP_SELF'])!="homepage.php"){echo "no";} ?>></iframe>
  </div>
  <div class="right"></div>
  </body>
</html>

