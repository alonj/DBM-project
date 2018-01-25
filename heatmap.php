<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
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

<div id="map">
<script>
function myMap() {
    var lat = $latitude;
    var lon = $longitude;
    var rad = $radius;
    var color = "#ff8785";
    var position = new google.maps.LatLng(lat, lon);
    var mapProp = {
        center:position,
        zoom:8
    };
    var map=new google.maps.Map(document.getElementById("map"),mapProp);
    var perimeter = new google.maps.Circle({center: position,
                                            radius: rad,
                                            strokeColor: color,
                                            strokeOpacity: 0.5,
                                            strokeWeight: 2,
                                            fillColor: color,
                                            fillOpacity: 0.2});
    perimeter.setMap(map);
    map.fitBounds(perimeter.getBounds());
    document.getElementById('map').scrollIntoView();
}
</script>
</div>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: alonj
 * Date: 20-Jan-18
 * Time: 15:40
 */
//Connect to SQL server
$latitude = 40.7128;
$longitude = -74.0060;
echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv6wuQJDE4QzG9Oy_FDXcOtuptY4Lksu8&callback=myMap"></script>';
sqlsrv_configure('WarningsReturnAsErrors', 0);
$conn = sqlsrv_connect($_SESSION["server"], $_SESSION["c"]);
if ($conn === false) {
    echo "error";
    die(print_r(sqlsrv_errors(), true));
}
if (isset($_POST["submit"])) {
    $hour= intval($_POST['hour']);
    $latitude = floatval($_POST['latitude']);
    $longitude = floatval($_POST['longitude']);
    $radius = intval($_POST['radius']);
    $create_view =   "SELECT count(car_id) AS heat
                      SELECT COUNT(rID)
                      FROM small_drive
                      WHERE (
                      small_drive.Ctime BETWEEN('".$hour."', DATEADD(hh,1,'".$hour."')) AND
                      ACOS(SIN('".$latitude."' *0.01745329252)*
                      SIN(project.RideP.latitude*0.01745329252) +
                      COS('".$latitude."'*0.01745329252)*
                      COS(project.RideP.latitude*0.01745329252)*
                      COS(0.01745329252*(project.RideP.longitude-'".$longitude."')))
                      *6371 <= ('".$radius."'/1000)
                      );";
    $result = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
    $count = $row['heat'];
    echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv6wuQJDE4QzG9Oy_FDXcOtuptY4Lksu8&callback=myMap"></script>';

}