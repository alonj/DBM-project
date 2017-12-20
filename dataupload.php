<html>
<head>
    <meta charset="utf-8" />
    <title>TED Stats - Add lectures from file</title>
</head>
<body>
<link href="styles.css" rel="stylesheet" type="text/css">
<div class="topbanner">
    <img src="hw3/ted-logo-transparent.png" class="title">
    <img src="hw3/stats.png" class="title">
    <p class="quote">Keep an eye on the popularity of TED talks, with an easy to use platform</p>
</div>
<div class="left">
    <ul>
        <li><a href="index.php">Homepage</a><br></li>
        <li>Add lectures from file (.csv format)<br></li>
        <li><a href="singlelec.php">Add lecture (singular form)</a><br></li>
    </ul>
</div>
<div class="middle">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
        <p style="font-family: Calibri; font-size: large" align="center">Upload a file (.csv format)</p>
        <div style="width: 10%; height: 100%; float: left">&nbsp;</div>
        <input type="file" name="infile" id="infile"><br><br>
        <input type="submit" name="submit" id="submit">
    </form>
</div>
<div class="right"></div>
<?php
if (isset($_POST["submit"])){
    $server = "tcp:techniondbcourse01.database.windows.net,1433";
    $c = array("Database" => "alonj", "UID" => "alonj", "PWD" => "Qwerty12!");
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($server, $c);
    if($conn === false)
    {
        echo "error";
        die(print_r(sqlsrv_errors(), true));
    }
        $file = $_FILES[infile][tmp_name];
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $sql="INSERT INTO Ted(name, main_speaker, description, event, languages, speaker_occupation, url, duration, comments, views) 
            VALUES  ('".addslashes($data[7])."',
                     '".addslashes($data[6])."',
                     '".addslashes($data[1])."',
                     '".addslashes($data[3])."',
                     '".addslashes($data[5])."',
                     '".addslashes($data[12])."',
                     '".addslashes($data[15])."',
                     '".addslashes($data[2])."',
                     '".addslashes($data[0])."',
                     '".addslashes($data[16])."'); 
             ";
            sqlsrv_query($conn, $sql);
        }
        fclose($handle); } }
?>

</body>
</html>