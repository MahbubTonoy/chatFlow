<?php
session_start();
?>
<?php require "logouter.php"; ?>
<?php require "connectscript.php"; ?>
<?php
if(isset($_REQUEST["msginc"])){
  $command = $_REQUEST["msginc"];
  if($command == "true"){
    $defcookie = $_REQUEST['msgnum'];
    setcookie("msgnum",$defcookie+15, time() + (86400 * 2), "/");
  }
  
}

?>