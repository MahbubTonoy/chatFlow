<?php
session_start();
?>
<?php

require "logouter.php";
require "connectscript.php";


if(isset($_REQUEST['getcom'])){
  $cid = $_REQUEST['getcom'];
  $sqlcom = "SELECT Stat FROM userdata WHERE SUname = '$cid';";
  $runsql = mysqli_query($dbconnect,$sqlcom);
  $dataTimestamp = mysqli_fetch_assoc($runsql)['Stat'];
  $now = date("YmdHis");
  if($dataTimestamp >= $now){
    echo "online";
  } else {
    echo "offline";
    //echo $dataTimestamp. " ". $now;
  }
}

?>