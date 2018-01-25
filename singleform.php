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
            <input type="number" title="dID" name="dID" required autofocus><br><br>
            Driver Name:<br>
            <input type="text" title="name" name="name" maxlength="50" required><br><br>
            Address:<br>
            <input type="text" title="address" name="address" maxlength="500" required><br><br>
            Date of Birth:<br>
            <input type="date" title="d_birth" name="d_birth" required max=<?php echo date('Y-m-d');?> value=<?php echo date('Y-m-d');?>><br><br>
            Main Hobby:<br>
            <input type="text" title="hobby" name="hobby" maxlength="5000" required><br><br>
        </div>
        <div style="clear:both"></div>
        <div style="padding-left: 40%; padding-top: 5%">
        <input type="submit" name="submit" value="Submit">
        <input type="reset" value="Reset form"><br><br>
        <div style="clear:both"></div>
        </div></p>
</form>
<?php
//Connect to SQL server
$server = "tcp:techniondbcourse01.database.windows.net,1433";
$c = array("Database" => "dbstudents", "UID" => "dbstudents", "PWD" => "Qwerty12!");
sqlsrv_configure('WarningsReturnAsErrors', 0);
$conn = sqlsrv_connect($server, $c);
if ($conn === false) {
    echo "error";
    die(print_r(sqlsrv_errors(), true));
}
if (isset($_POST["submit"])) {
    $dID = addslashes($_POST['dID']);
    $name = addslashes($_POST['name']);
    $address = addslashes($_POST['address']);
    $d_birth = addslashes($_POST['d_birth']);
    $hobby = addslashes($_POST['hobby']);
/*  $dID_int = intval($dID);
    $check_unique = "SELECT dID
                        FROM project.Driver
                        WHERE dID=".$dID_int;
       $result = sqlsrv_query($conn, $check_unique);*/
//    if(sqlsrv_num_rows($result) == 0) { //Insert form data into "Driver" table if dID does not already exist
        $insert = "INSERT INTO driver(driver_id,  name,  date_of_birth,  address,  hobby)
                        VALUES('" . $dID . " ',  
                               '" . $name . "',
                               '" . $d_birth . "',
                               '" . $address . "',
                               '" . $hobby . "');";
        $result = sqlsrv_query($conn, $sql);
        if (!$result) {
            echo '<script language = "javascript">';
            echo 'alert("Update failure!")';
            echo '</script>';
            die();
        }
        else {
            echo '<script language = "javascript">';
            echo 'alert("Update successful!")';
            echo '</script>';
        }
/*    }
    else{
        echo '<script language = "javascript">';
        echo 'alert("Driver ID already in database!")';
        echo '</script>';
        die();
    }*/
}
?>
</body>
</html>