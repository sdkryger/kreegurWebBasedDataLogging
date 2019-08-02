<?php
header('Content-Type: application/json');

include 'functions.php';

$response = new stdClass();
$response->error = true;
$response->message = "Could not connect to the database";



$hostname = "localhost";
$username = "phpUser";
$password = "phpUser2";
$dbName = "main";

$mysqli = new mysqli($hostname,$username,$password,$dbName);

$response->message = "Able to connect to the database";
if(isset($_REQUEST['tagName']) && isset($_REQUEST['value'])){
    $response->error = false;
    $tagName = (string)$_REQUEST['tagName'];
    $value = (string)$_REQUEST['value'];
    $s = $mysqli->prepare("update latestValues set value = ?, lastUpdate = ? where tagName = ?");
    $t = timestamp();
    $s->bind_param('sss',$value,$t,$tagName);
    $s->execute();
    if($s->affected_rows == 0){
        $s2 = $mysqli->prepare("select * from latestValues where tagName = ?");
        $s2->bind_param('s',$tagName);
        $s2->execute();
        $s2->store_result();
        //print_r($s2);
        if($s2->num_rows == 0){
            $s = $mysqli->prepare("insert into latestValues (tagName, value, lastUpdate) values (?, ?, ?)");
            $s->bind_param('sss',$tagName,$value,$t);
            $s->execute();
        }
    }
    $tableName = "tag_".$tagName;
    if($mysqli->query("show tables like '".$tableName."'")->num_rows == 0){
        
        //echo "table does not exist";
        $sql = "create table ".$tableName."( id int not null auto_increment primary key, timestamp datetime, value varchar(255))";
        $mysqli->query($sql);
    }

    $sql = "insert into ".$tableName." (timestamp, value) values (?, ?)";
    $s = $mysqli->prepare($sql);
    $s->bind_param('ss',$t,$value);
    $s->execute();
    
    

} else {
    $response->message = "Must specify tagName and Value";
}


$response->executionTimeSeconds = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
$response->serverIp = $_SERVER['SERVER_ADDR'];
$response->remoteIp = $_SERVER['REMOTE_ADDR'];
$response->freeSpace = disk_free_space("/");
echo json_encode($response);