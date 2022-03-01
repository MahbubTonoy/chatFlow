<?php require "connectscript.php"; ?>
<?php 
    $localuser = $_COOKIE['user'];
    $sqlcom = "SELECT DISTINCT sender_suname, receiver_suname FROM msgs WHERE sender_suname = '$localuser' OR receiver_suname = '$localuser'  ORDER BY dateofmsg DESC;";
    $runsql = mysqli_query($dbconnect,$sqlcom);
    while($mydata = mysqli_fetch_assoc($runsql)){
      if($mydata['sender_suname'] == "$localuser" ){
        $cid1 = $mydata['receiver_suname'];
        $sqlcom1 = "SELECT Stat FROM userdata WHERE SUname = '$cid1';";
        $runsql1 = mysqli_query($dbconnect,$sqlcom1);
        $dataTimestamp1 = mysqli_fetch_assoc($runsql1)['Stat'];
        $now = date("YmdHis")+50000;
        if($dataTimestamp1 > $now){
          $items[$mydata['receiver_suname']] = $mydata;
        }
      }
      if($mydata['receiver_suname'] == "$localuser" ){
        $cid2 = $mydata['sender_suname'];
        $sqlcom2 = "SELECT Stat FROM userdata WHERE SUname = '$cid2';";
        $runsql2 = mysqli_query($dbconnect,$sqlcom2);
        $dataTimestamp2 = mysqli_fetch_assoc($runsql2)['Stat'];
        $now2 = date("YmdHis")+50000;
        if($dataTimestamp2 > $now2){
          $items[$mydata['sender_suname']] = $mydata;
        }
      }
    }
    if(!empty($items)){
      foreach($items as $item){
        if($item['sender_suname'] == "$localuser" ){
          $getname = $item['receiver_suname'];
          $sqlcom1 = "SELECT Fullname, DP FROM userdata WHERE SUname = '$getname';";
          $runsql1 = mysqli_query($dbconnect,$sqlcom1);
          $getthedata = mysqli_fetch_assoc($runsql1);
          echo "<a class = 'anchors' style = 'color:#333;' href = 'chatflow.php?msgid=$getname' ><div  style = 'margin:0px 0px;padding: 5px 0px; border-bottom:1px solid #eee; padding:15px;' class = 'row read".$getname." '>";
            if($getthedata['DP'] == "N/A"){
              echo "<style>.imgcont".$getname."{background-image:url('avatar/default/chatlist_avatar.png');background-position:center;background-size: cover;}</style>";
            } else {
              $getimgs1 = $getthedata['DP'];
							echo "<style>.imgcont".$getname."{background-image:url('$getimgs1');background-position:center;background-size: cover;}</style>";
            }
            echo "<div style = 'border-radius:25px; height:50px; width: 50px; margin-right:15px;' class = 'imgcont".$getname."' ></div>";
            echo "<div style = 'display:inline;' >
              <h4 style = 'display:inline; margin-top:10px; margin-left:5px;'>".$getthedata['Fullname']."</h4>
            </div><br/>";
          echo "</div></a>";
        }
        if($item['receiver_suname'] == "$localuser" ){
          $getname2 = $item['sender_suname'];
          $sqlcom2 = "SELECT Fullname, DP FROM userdata WHERE SUname = '$getname2';";
          $runsql2 = mysqli_query($dbconnect,$sqlcom2);
          $getthedata = mysqli_fetch_assoc($runsql2);
          echo "<a class = 'anchors' style = 'color:#333;' href = 'chatflow.php?msgid=$getname2' ><div  style = 'margin:0px 0px;padding: 5px 0px; border-bottom:1px solid #eee; padding:15px;' class = 'row read".$getname2." '>";
            if($getthedata['DP'] == "N/A"){
              echo "<style>.imgcont".$getname2."{background-image:url('avatar/default/chatlist_avatar.png');background-position:center;background-size: cover;}</style>";
            } else {
              $getimgs1 = $getthedata['DP'];
							echo "<style>.imgcont".$getname2."{background-image:url('$getimgs1');background-position:center;background-size: cover;}</style>";
            }
            echo "<div style = 'border-radius:25px; height:50px; width: 50px; margin-right:15px;' class = 'imgcont".$getname2."' ></div>";
            echo "<div style = 'display:inline;' >
              <h4 style = 'display:inline; margin-top:10px; margin-left:5px;'>".$getthedata['Fullname']."</h4>
            </div><br/>";
          echo "</div></a>";
        } 
    
      }
      echo "<style>.div-alert-blue {display: block;} .div-alert-yellow {display:none;}</style>";
    } else {
      echo "<style>.div-alert-blue {display: none;} .div-alert-yellow {display:block;}</style>";
    }
    
  
?>
<style>
	 .anchors:hover{
		text-decoration:none;
	 }
	 .row:hover{
		 background-color:#eee;
		 border-radius: 5px;
	 }
	 .row{
			font-family: Verdana,sans-serif;
	 }
</style>