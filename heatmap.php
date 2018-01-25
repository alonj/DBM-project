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
        Radius (Kilometres):<br>
        <input type="number" step="any" title="radius" name="radius" maxlength="500" required><br><br>
    </div>
    <div style="clear:both"></div>
    <div style="padding-left: 40%; padding-top: 5%">
        <input type="submit" name="submit" value="Submit">
        <input type="reset" value="Reset form"><br><br>
        <div style="clear:both"></div>
    </div>
</form>
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
    $radius_km = intval($_POST['radius']);
    $sql = "  SELECT count(car_id) AS heat
                FROM small_drive
                WHERE (
                  (datepart(HOUR,Ctime) = ". $hour .") AND
                  (12749.19148 *
                  asin(sqrt(
                            power(
                                (sin
                                    (radians((". $latitude ."-location_lat)/2)
                                    )
                                ),2)+
                            cos(radians(location_lat))*
                            cos(radians(". $latitude ."))*
                            power((sin(radians((". $longitude ."-location_long)/2))),2))) < ". $radius_km ."))";
    $result = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $heat = $row['heat'];
    $color = "#7a97ff";
    if($heat <= 50 and $heat > 20){
        $color = "#d477cf";
    }
    elseif ($heat > 50){
        $color = "#d65562";
    }
    echo '<script language = "javascript">';
    echo 'alert("'. $heat .'");';
    echo '</script>';

?>
<div>
    <div id="googleMap">
    <script>
        function myMap() {
            var qLat =  <?php echo json_encode($latitude,JSON_NUMERIC_CHECK); ?>;
            var qLng = <?php echo json_encode($longitude,JSON_NUMERIC_CHECK); ?>;
            var qRadius = <?php echo json_encode($radius_km,JSON_NUMERIC_CHECK); ?>;
            var qColor = <?php echo json_encode($color); ?>;
            var qPos = new google.maps.LatLng(qLat, qLng);
            var mapProp = {
                center: qPos,
                zoom: 10
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            var qCircle = new google.maps.Circle({
                center: qPos,
                radius: qRadius,
                strokeColor: qColor,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: qColor,
                fillOpacity: 0.4
            });
            qCircle.setMap(map);
            map.fitBounds(qCircle.getBounds());//fits the maps bounds to circle
            document.getElementById('googleMap').scrollIntoView();
        }
    </script>
    </div>
    <?php
    echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_ml_vTDIuJm62aNLcPfmXgbOhTxGb7KE&callback=myMap"></script>';}
    ?>
</div>

<!--<div id="map_div">
    <script>
        function myMap() {
            var lat = <?php /*echo json_encode($latitude); */?>;
            var lon = <?php /*echo json_encode($longitude); */?>;
            var rad = <?php /*echo json_encode($radius_km); */?>;
            var color =<?php /*echo json_encode("#ff948e"); */?>;
            var position = new google.maps.LatLng(lat, lon);
            var mapProp = {
                center:position,
                zoom:8
            };
            var map=new google.maps.Map(document.getElementById("map_div"),mapProp);
            var perimeter = new google.maps.Circle({center: position,
                                                    radius: rad,
                                                    strokeColor: color,
                                                    strokeOpacity: 0.5,
                                                    strokeWeight: 2,
                                                    fillColor: color,
                                                    fillOpacity: 0.2});
            perimeter.setMap(map);
            map.fitBounds(perimeter.getBounds());
            document.getElementById('map_div').scrollIntoView();
        }
    </script>
</div>
--><?php /*echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_ml_vTDIuJm62aNLcPfmXgbOhTxGb7KE&callback=myMap"></script>';}*/?>
</body>
</html>
