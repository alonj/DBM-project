<?php session_start(); ?>
<html>
<head>
    <meta charset="utf-8" />
</head>
<body>
<link rel="stylesheet" href='styles.css' type="text/css">
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="width: 100%; background-color: white; float: left; min-height: 100%">
        <div style="float: left; padding-left: 20%; padding-top: 5%; font-family: Calibri">
            All fields required!<br><br>
            Driver ID:<br>
            <input type="text" title="driver_id" name="driver_id" size="25" required autofocus><br><br>
            Driver Name:<br>
            <input type="text" title="name" name="name" size="20" required><br><br>
            Date of Birth:<br>
            <input type="date" title="birthday" name="birthday" size="25" required max=<?php echo date('Y-m-d');?> value=<?php echo date('Y-m-d');?>><br><br>
            Address:<br>
            <input type="text" title="address" name="address" size="25" required><br><br>
            Main Hobby:<br>
            <input type="text" title="hobby" name="hobby" size="25" required><br><br>
        </div>
        <div style="clear:both"></div>
        <div style="padding-left: 40%; padding-top: 5%">
        <input type="submit" name="submit" value="Submit">
        <input type="reset" value="Reset form"><br><br>
        <div style="clear:both"></div>
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
    $sql = "INSERT INTO driver(driver_id, name, date_of_birth, address, hobby) 
        VALUES ('" . addslashes($_POST['driver_id']) . "',
                '" . addslashes($_POST['name']) . "',
                '" . addslashes($_POST['birthday']) . "',
                '" . addslashes($_POST['address']) . "',
                '" . addslashes($_POST['hobby']) . "');";
    $result = sqlsrv_query($conn, $sql);
    if($result === false){
        echo '<script language = "javascript">';
        echo 'alert("Submission failed")';
        echo '</script>';
    }
    else{
        echo '<script language = "javascript">';
        echo 'alert("Submission succeeded!")';
        echo '</script>';
    }
}
?>
</body>
</html>