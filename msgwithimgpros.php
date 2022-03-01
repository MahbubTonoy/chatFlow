<?php
session_start();
?>
<?php require "connectscript.php"; ?>
<?php
if($_FILES["imgup"]["name"] != "" && isset($_REQUEST['recid']) && isset($_REQUEST['senid'])){ //&& isset($_REQUEST['recid'])
  $file = $_FILES['imgup']['name'];
  $test = explode(".",$file);
  $extention = end($test);
  $r = $_REQUEST['recid'];
  $s = $_REQUEST['senid'];

  $sqlcom = "SELECT * FROM `msgs` ORDER BY `ID` DESC LIMIT 1";
  $runsql = mysqli_query($dbconnect, $sqlcom);
  if(mysqli_num_rows($runsql) == 0){
    $name = "cf_".$s."_".$r."_0.".$extention;
  } else {
    $getval = mysqli_fetch_assoc($runsql)['ID'];
    $name = "cf_".$s."_".$r."_".$getval.".".$extention;
  }
  if($extention == "jpg" || $extention == "jpeg" || $extention == "png" || $extention == "gif"){
    $sqlcom = "INSERT INTO msgs(sender_suname,receiver_suname,content,imgs) VALUES('$s','$r','Sent An Image','$name');";
    mysqli_query($dbconnect,$sqlcom);

    $location =  "images/cf/".$name;
    move_uploaded_file($_FILES['imgup']['tmp_name'],$location);
    //echo "done";
  } else {
    //echo $extention;
  }
  
  
}


?>