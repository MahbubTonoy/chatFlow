<?php require "connectscript.php"; ?>
<?php 
  if(isset($_REQUEST['postdata'])){
    $user = $_REQUEST['postdata'];
    $sqlcom = "SELECT sender_suname, stat, dateofmsg FROM msgs WHERE receiver_suname = '$user' AND NOT stat = 'seen' AND NOT stat = 'notified' ORDER BY dateofmsg DESC";
    $runsql = mysqli_query($dbconnect,$sqlcom);
    if(mysqli_num_rows($runsql) != 0){
        echo "true";
        $sqlcom = "UPDATE msgs set stat = 'notified' WHERE receiver_suname = '$user' AND NOT stat = 'seen' AND NOT stat = 'notified';";
        $runsql = mysqli_query($dbconnect,$sqlcom);
    }
  } else {
    echo "could not get request data";
  }

?>