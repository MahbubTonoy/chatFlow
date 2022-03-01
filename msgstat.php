<?php require "logouter.php"; ?>
<?php require "securedata.php";?>
<?php require "connectscript.php"; ?>
<?php 
if(isset($_REQUEST['stat'])){
  //$stat = msec($_REQUEST['stat']);
  $rec = msec($_REQUEST['rec']);
  $sqlcom = "UPDATE msgs SET stat = 'seen' WHERE sender_suname = '$rec'; ";
  $runsql = mysqli_query($dbconnect, $sqlcom);

} else {
  //header("location: chatlist.php?lakeofdata=true");
}
?>