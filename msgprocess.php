<?php require "logouter.php"; ?>
<?php require "securedata.php"; ?>
<?php require "connectscript.php"; ?>
<?php 
  if(isset($_REQUEST['getstdid']) && isset($_REQUEST['getmsgid']) && isset($_REQUEST['getrtdid']) ){
    $getstdid = msec($_REQUEST['getstdid']);
    $getmsgid = $_REQUEST['getmsgid'];
    $getrtdid = msec($_REQUEST['getrtdid']);
    $sqlcom = "INSERT INTO msgs(sender_suname, content, receiver_suname) VALUES('$getstdid','$getmsgid','$getrtdid')";
    $runsql = mysqli_query($dbconnect, $sqlcom);
    if($runsql === true){
      echo "success";
    } else {
      echo "failed ".mysqli_error($dbconnect);
    }
    //echo "\n$getstdid\n$getmsgid\n$getrtdid";
  } else {
    header("location: chatlist.php?lakeofdata=true");
  }
  
?>