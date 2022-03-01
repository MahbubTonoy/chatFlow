<?php
session_start();
?>
<?php require "connectscript.php"; ?>
<?php
  $usr = $_REQUEST['getusr'];
  $sqlcom = "UPDATE userdata SET Stat = now()+10 WHERE SUname = '$usr'";

  $runsql = mysqli_query($dbconnect, $sqlcom);

?>