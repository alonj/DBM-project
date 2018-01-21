<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
    </style>
</head>
<body>
<link rel="stylesheet" href='styles.css' type="text/css">
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="width: 100%; background-color: white; float: left; min-height: 100%">
    <div style="float: left; padding-left: 20%; padding-top: 5%; font-family: Calibri">
        Hour:<br>
        <input type="number" title="hour" name="hour" min="1" max="24" required autofocus><br><br>
        Latitude:
        <input type="number" step="any" title="latitude" name="latitude" max="90" min="-90" required>
        Longitude:
        <input type="number" step="any" title="longitude" name="longitude" max="180" min="-180" required><br><br>
        Radius (metres):<br>
        <input type="number" title="radius" name="radius" maxlength="500" required><br><br>
    </div>
    <div style="clear:both"></div>
    <div style="padding-left: 40%; padding-top: 5%">
        <input type="submit" name="submit" value="Submit">
        <input type="reset" value="Reset form"><br><br>
        <div style="clear:both"></div>
    </div></p>
</form>

<div id="map"></div>
<script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 8
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_ml_vTDIuJm62aNLcPfmXgbOhTxGb7KE&callback=initMap"
        async defer></script>

<?php
/**
 * Created by PhpStorm.
 * User: alonj
 * Date: 20-Jan-18
 * Time: 15:40
 */
//Connect to SQL server
$server = "tcp:techniondbcourse01.database.windows.net,1433";
$c = array("Database" => "alonj", "UID" => "alonj", "PWD" => "Qwerty12!");
sqlsrv_configure('WarningsReturnAsErrors', 0);
$conn = sqlsrv_connect($server, $c);
if ($conn === false) {
    echo "error";
    die(print_r(sqlsrv_errors(), true));
}
if (isset($_POST["submit"])) {
    $hour= intval($_POST['hour']);
    $latitude = floatval($_POST['latitude']);
    $longitude = floatval($_POST['longitude']);
    $radius = intval($_POST['radius']);
    $create_view =   "CREATE OR REPLACE VIEW project.Heatmap AS
                      SELECT COUNT(rID)
                      FROM project.RideP
                      WHERE (
                      RideP.time BETWEEN('".$hour."', DATEADD(hh,1,'".$hour."')) AND
                      ACOS(SIN('".$latitude."' *0.01745329252)*
                      SIN(project.RideP.latitude*0.01745329252) +
                      COS('".$latitude."'*0.01745329252)*
                      COS(project.RideP.latitude*0.01745329252)*
                      COS(0.01745329252*(project.RideP.longitude-'".$longitude."')))
                      *6371 <= ('".$radius."'/1000)
                      );";
    $result = sqlsrv_query($conn, $sql);
    $query = "SELECT * FROM project.Heatmap";
    echo $query;
}
?>
</body>
</html>