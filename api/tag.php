<?php
header('Content-Type: application/json');

include 'functions.php';
$response = new stdClass();
$response->error = true;
$response->message = "Could not connect to the database";

if(isset($_REQUEST['name'])){
    $tagName = $_REQUEST['name'];
    $response->error = false;
    $response->message = "tagName: ".$tagName;
    $hostname = "localhost";
    $username = "phpUser";
    $password = "phpUser2";
    $db = "main";
    $mysqli = new mysqli($hostname,$username,$password,$db);
    $tableName = 'tag_'.$tagName;
    $sql = "select count(*) as count, min(timestamp) as startTime, max(timestamp) as endTime from ".$tableName;
    $query = $mysqli->query($sql);
    while ($row = mysqli_fetch_array($query)) {
        $response->count = $row['count'];
        $response->startTime = $row['startTime'];
        $response->endTime = $row['endTime'];
    }
    $response->currentTime = timestamp();
    $time = new DateTime();
    $response->nowTime = $time;
    $days = 2;
    $response->deleteTime = $time->sub(new DateInterval('P'.$days.'D'));
}


$response->executionTimeSeconds = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
echo json_encode($response);
?>