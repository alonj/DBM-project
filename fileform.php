<?php session_start(); ?>
<html>
<head>
    <meta charset="utf-8" />
    <title>New York - Public Transportation</title>
</head>
<body style="background-color: white">
<link href="styles.css" rel="stylesheet" type="text/css">
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data" style="background-color: white">
    <br>
    <p style="font-family: Calibri; font-size: large" align="center">Upload a file (.csv format)</p>
    <div style="padding-left: 20%; height: 100%; width: 100%; float: left; background-color: white">
        <input type="file" name="infile" id="infile"><br><br>
        <input type="submit" name="submit" id="submit">
    </div>
</form>
<?php
if (isset($_POST["submit"])){
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($_SESSION["server"], $_SESSION["c"]);
    if($conn === false)
    {
        echo '<script language = "javascript">';
        echo 'alert("Connection to database failed!")';
        echo '</script>';
        die(print_r(sqlsrv_errors(), true));
    }
    $file = $_FILES[infile][tmp_name];
    $empty = empty($file) || (count($file) === 1 && $file[0] === '');
    if ($empty === true){
        echo '<script language = "javascript">';
        echo 'alert("Uploaded file is empty!")';
        echo '</script>';
        die();
    }
    elseif (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $sql="INSERT INTO dbstudents.dbo.small_drive(car_id, location_lat, location_long, Ctime) 
            VALUES  ('".addslashes($data[4])."',
                     '".addslashes($data[2])."',
                     '".addslashes($data[3])."',
                     '".addslashes($data[1])."');";
            sqlsrv_query($conn, $sql);
        }
        fclose($handle);
        echo '<script language = "javascript">';
        echo 'alert("Upload successful!")';
        echo '</script>';
    } }
?>
</body>
</html>