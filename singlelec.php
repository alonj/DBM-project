<?php

//Get form data from singlelec.html

$name = htmlspecialchars($_POST['name']);
$main_speaker = htmlspecialchars($_POST['main_speaker']);
$description = htmlspecialchars($_POST['description']);
$event = htmlspecialchars($_POST['event']);
$languages = htmlspecialchars($_POST['languages']);
$speaker_occupation = htmlspecialchars($_POST['speaker_occupation']);
$url = htmlspecialchars($_POST['url']);
$duration = htmlspecialchars($_POST['duration']);

//Connect to SQL server
$server = "tcp:techniondbcourse01.database.windows.net,1433";
$c = array("Database" => "alonj", "UID" => "alonj", "PWD" => "Qwerty12!");
sqlsrv_configure('WarningsReturnAsErrors', 0);
$conn = sqlsrv_connect($server, $c);
if($conn === false)
{
    echo "error";
    die(print_r(sqlsrv_errors(), true));
}

//Insert form data into "Ted" table
$sql = "INSERT INTO Ted(main_speaker, name, description, event, languages, speaker_occupation, url, duration)
        VALUES($name, $main_speaker, $description, $event, $languages, $speaker_occupation, $url, $duration);";
sqlsrv_query($conn, $sql);
sqlsrv_close($conn);

