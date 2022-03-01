<?php
$dbhost = "localhost";
$dbusr = "root";
$dbpw = "";
$dbname = "chatflow";
$dbconnect = mysqli_connect($dbhost, $dbusr, $dbpw, $dbname);
if(!$dbconnect){
    //echo "Could Not Connect Database.";
}
?>
