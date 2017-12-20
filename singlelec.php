<html>
<head>
    <meta charset="utf-8" />
    <title>TED Stats - Add a single lecture</title>
</head>
<body>
<link rel="stylesheet" href='styles.css' type="text/css">
<div class="topbanner">
    <img src="hw3/ted-logo-transparent.png" class="title">
    <img src="hw3/stats.png" class="title">
    <p class="quote">Keep an eye on the popularity of TED talks, with an easy to use platform</p>
</div>
<div class="left">
    <ul>
        <li><a href="index.php">Homepage</a><br></li>
        <li><a href="dataupload.php">Add lectures from file (.csv format)</a><br></li>
        <li>Add lecture (singular form)<br></li>
    </ul>
</div>
<!--<div class="middle">-->

    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="width: 60%; background-color: white; float: left">
        <!--<div style="width: 10%; height: 90%; float: left">&nbsp;</div>-->
        <p style="font-family: Calibri; height: 100%; padding-left: 15%; padding-top: 5%; overflow-y: auto">
            Lecture Name (*):<br>
            <input type="text" title="name" name="name" maxlength="5000" required autofocus><br><br>
            Main Speaker:<br>
            <input type="text" title="main_speakers" name="main_speaker" maxlength="5000"><br><br>
            Description:<br>
            <textarea name="description"
                      placeholder="Add a short description of the lecture."
                      style="word-wrap: break-word;
                             min-height: 100px;
                             min-width: 25%;"></textarea><br><br>
            Event:<br>
            <input type="text" title="event" name="event" maxlength="5000"><br><br>
            Number of Languages:<br>
            <input type="number" title="languages" name="languages" min="1" max="9999"><br><br>
            Speaker Occupation:<br>
            <input type="text" title="speaker occupation" name="speaker_occupation"><br><br>
            URL:<br>
            <input type="url" title="URL" name="url" maxlength="5000"><br><br>
            Duration (in minutes):<br>
            <input type="number" title="duration" name="duration" max="999" min="1"><br><br>
            Current Number of Views:<br>
            <input type="number" title="views" name="views"><br><br>
            Current Number of Comments:<br>
            <input type="number" title="comments" name="comments">
        </p>
        <p align="center" style="font-family: Calibri; height: fit-content; background-color: white; padding-top: 0px">
            <input type="submit" value="Submit" align="center">
            <input type="reset" value="Reset form"> <br>
        (*) - indicates required fields
        </p>
    </form>
<?php
if (isset($_POST["submit"])) {
    //Get form data from singlelec.html
    $name = htmlspecialchars($_POST['name']);
    $main_speaker = htmlspecialchars($_POST['main_speaker']);
    $description = htmlspecialchars($_POST['description']);
    $event = htmlspecialchars($_POST['event']);
    $languages = htmlspecialchars($_POST['languages']);
    $speaker_occupation = htmlspecialchars($_POST['speaker_occupation']);
    $url = htmlspecialchars($_POST['url']);
    $duration = htmlspecialchars($_POST['duration']);
    $comments = htmlspecialchars($_POST['comments']);
    $views = htmlspecialchars($_POST['views']);

    //Connect to SQL server
    $server = "tcp:techniondbcourse01.database.windows.net,1433";
    $c = array("Database" => "alonj", "UID" => "alonj", "PWD" => "Qwerty12!");
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($server, $c);
    if ($conn === false) {
        echo "error";
        die(print_r(sqlsrv_errors(), true));
    }

    //Insert form data into "Ted" table
    $sql = "INSERT INTO Ted(name,  main_speaker,  description,  event,  languages,  speaker_occupation,  url,  duration, comments, views)
                    VALUES('" . $name . "', 
                           '" . $main_speaker . "',
                           '" . $description . "',
                           '" . $event . "',
                           '" . $languages . "',
                           '" . $speaker_occupation . "',
                           '" . $url . "',
                           '" . $duration . "',
                           '" . $comments . "',
                           '" . $views . "');";
    $result = sqlsrv_query($conn, $sql);
}
?>
<!--</div>-->
<div class="right"></div>
</body>
</html>