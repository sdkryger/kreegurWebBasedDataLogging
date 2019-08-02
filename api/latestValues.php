<?php
header('Content-Type: application/json');
$response = new stdClass();
$response->error = true;
$response->message = "Could not connect to the database";
/*
$db = new SQLite3('../main.db');
$sql = "select * from latestValues order by tagName;";
$results = $db->query($sql);
$values = array();
while($row = $results->fetchArray()){
    //print_r($row);
    $value = new stdClass();
    $value->id = $row['id'];
    $value->name = $row['tagName'];
    $value->value = $row['value'];
    $value->lastUpdate = $row['lastUpdate'];
    array_push($values, $value);
    $response->error = false;
    $response->message = "Success";
}
$response->values = $values;
$db->close();
*/

$hostname = "localhost";
$username = "phpUser";
$password = "phpUser2";
$db = "main";

//$dbconnect=mysqli_connect($hostname,$username,$password,$db);
$mysqli = new mysqli($hostname,$username,$password,$db);
$values = array();
if (!$mysqli->connect_errno) {
    //$query = mysqli_query($dbconnect, "SELECT * FROM latestValues");
    $query = $mysqli->query("Select * from latestValues");
    while ($row = mysqli_fetch_array($query)) {
        //print_r($row);
        $value = new stdClass();
        $value->id = $row['id'];
        $value->name = $row['tagName'];
        $value->value = $row['value'];
        $value->lastUpdate = $row['lastUpdate'];
        array_push($values, $value);
        $response->error = false;
        $response->message = "Success";
    }
}
$response->values = $values;

$response->executionTimeSeconds = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
echo json_encode($response);
?>