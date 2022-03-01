<?php
session_start();
?>
<?php require "logouter.php"; ?>
<?php require "connectscript.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php
    $cookieuser = $_COOKIE['user'];
    $sqlcom = "SELECT DP, Fullname FROM userdata WHERE SUname = '$cookieuser'";
    $runsql = mysqli_query($dbconnect, $sqlcom);
    $dps = mysqli_fetch_assoc($runsql);
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $dps['Fullname']; ?> | <?php require "sitename.php"; ?></title>
    <link rel="stylesheet" href="stylesheets/main.css" type="text/css" />
    <link rel="stylesheet" href="stylesheets/reset.css" type="text/css" />
    <?php require "bootstrap.php" ?>
    <?php require "header.php"; ?>
</head>

<body>

    <div class="container">
        <div class="header">
            <?php require "navbar.php" ?>
			<hr style = "display:inline-block;height: 1px; background-color: #d0f0f0; width: 100%; margin:0px;" />
            <style>
                .dp
                .proinfo {
                    display: inline-block;
                }
            </style>
            <div style="position:relative;" class="dis-profiles row">
				
                <div class="text-center dp col-lg-2 col-md-3 col-sm-12">
                    <?php
                    if ($dps['DP'] == "N/A") {
                        require "uploaddp.php";
                    } else {
                        require "showdp.php";
                        if (isset($_REQUEST['upload'])) {
                            $filearr = $_FILES['dpup'];
                            $filetmp = $filearr['tmp_name'];
                            $sqlcom = "SELECT SUname, ID FROM userdata WHERE SUname = '$cookieuser'";
                            $runsql = mysqli_query($dbconnect, $sqlcom);
                            $getdata = mysqli_fetch_assoc($runsql);
                            $newfilename = "avatar/dp_" . $getdata['SUname'] . "_" . $getdata['ID'] . ".jpg";
                            move_uploaded_file($filetmp, $newfilename);
                            $sqlcom = "UPDATE userdata SET DP = '$newfilename' WHERE SUname = '$cookieuser'";
                            mysqli_query($dbconnect, $sqlcom);
                        }
                    }
                    ?>
                </div>
                
                <div class="proinfo col-lg-10 col-md-9 col-sm-12 text-md-left text-sm-center text-xs-center">
                    <style>
                    .usrfulnm{
                        margin-top: 30px;
                    }
                    .usrids{
                        margin-top: 5px;
                        font-weight: thin;
                        color: gray;
                    }
                    
                    </style>
                    <?php

                    $sqlcon = "SELECT Fullname, Username FROM userdata WHERE SUname =  '$cookieuser'";
                    $runq = mysqli_query($dbconnect, $sqlcon);
                    $qc = mysqli_fetch_assoc($runq);
                    if (mysqli_num_rows($runq) == 1) {
                        echo "<h4 class = 'usrfulnm' style = 'display: inline-block;'>" . $qc['Fullname'] . "</h4>";
                        echo "<br/><h5 class = 'usrids' style = 'display: inline-block;'>@" . $qc['Username'] . "</h5>";
                    }

                    ?>

                </div>
                <!---div style = "position:absolute;" class = "changecp">Okey</div-->
                <div style = "clear:both"></div>
            </div>
        </div>
        <?php
          echo "<h4 style = 'padding:10px 5px; border-bottom: 1px solid #ddd;'>Friends</h4>";
          $currentusr = $_COOKIE['user'];
          $sqlcom = "SELECT DISTINCT sender_suname, receiver_suname, dateofmsg FROM msgs WHERE sender_suname = '$currentusr' OR receiver_suname = '$currentusr' ORDER BY dateofmsg DESC";
          $runsql = mysqli_query($dbconnect,$sqlcom);
          if(mysqli_num_rows($runsql) == 0){
            echo "<div style = 'margin:10px;' class = 'alert alert-warning'>You Have No Friends.<br/>Search For Friends:<form style = 'margin: 10px;' action = 'search.php' method = 'get'>
            <input style = 'margin: 2px 10px 2px 0px;' class = 'form-control' type = 'search' name = 'q' placeholder = 'Search Friends...' />
            <input type = 'submit' value = 'Search' class = 'btn btn-primary' />
            </form></div>";
          } else {
            $limit = 0;
            while($mydata = mysqli_fetch_assoc($runsql)){
              if($mydata['sender_suname'] == $currentusr  ){
                $items[$mydata['receiver_suname']] = $mydata;
              }
              if($mydata['receiver_suname'] == $currentusr  ){
                $items[$mydata['sender_suname']] = $mydata;
              }
            }

            foreach($items as $item){
              if($item['sender_suname'] == "$currentusr" ){
                $getname = $item['receiver_suname'];
                $sqlcom1 = "SELECT Fullname, DP, ID, SUname FROM userdata WHERE SUname = '$getname';";
                $runsql1 = mysqli_query($dbconnect,$sqlcom1);
                $getbackdata = mysqli_fetch_assoc($runsql1);
                $getsuname2 = $getbackdata['SUname'];
                  echo "<a class = 'anchors' style = 'color:#333;' href = 'chatflow.php?msgid=$getsuname2' ><div style = 'margin:0px 0px;padding: 5px 0px; border-bottom:1px solid #eee; padding:15px;' class = 'row rows read".$getsuname2."' >"; 
                  echo "<div style = 'display:inline;' >";
                  $getid1 = $getbackdata['ID'];
                    if($getbackdata['DP'] == 'N/A'){
                      echo "<style>.imgcont".$getid1."{background-image:url('avatar/default/chatlist_avatar.png');background-position:center;background-size: cover;}</style>";
                    } else {
                        $getimgs1 = $getbackdata['DP'];
                        echo "<style>.imgcont".$getid1."{background-image:url('$getimgs1');background-position:center;background-size: cover;}</style>";
                    }
                    echo "<div style = 'border-radius:25px; height:50px; width: 50px; margin-right:15px;' class = 'imgcont".$getid1."' ></div>";
                    echo "</div>";
                    echo "<div style = 'display:inline;' >";
                    echo "<h4 style = 'display:inline; margin-top:10px; margin-left:5px;'>".$getbackdata['Fullname']."</h4>";
                    echo "</div>";
                    echo "</div></a>";
                  }
                  if($item['receiver_suname'] == "$currentusr" ){
                    $getname = $item['sender_suname'];
                    $sqlcom2 = "SELECT Fullname, DP, ID, SUname FROM userdata WHERE SUname = '$getname';";
                    $runsql2 = mysqli_query($dbconnect,$sqlcom2);
                    $getbackdata2 = mysqli_fetch_assoc($runsql2);
                    $getsuname2 = $getbackdata2['SUname'];
                    echo "<a class = 'anchors' style = 'color:#333;' href = 'chatflow.php?msgid=$getsuname2' ><div style = 'margin:0px 0px;padding: 5px 0px; border-bottom:1px solid #eee; padding:15px;' class = 'row rows read".$getsuname2."' >";
                    echo "<div style = 'display:inline;' >";
                    $getid2 = $getbackdata2['ID'];
                    if($getbackdata2['DP'] == 'N/A'){
                      echo "<style>.imgcont".$getid2."{background-image:url('avatar/default/chatlist_avatar.png');background-position:center;background-size: cover;}</style>";
                    } else {
                      $getimgs2 = $getbackdata2['DP'];
                      echo "<style>.imgcont".$getid2."{background-image:url('$getimgs2');background-position:center;background-size: cover;}</style>";
                    }
                      echo "<div style = 'border-radius:25px; height:50px; width: 50px; margin-right:15px;' class = 'imgcont".$getid2."' ></div>";
                      echo "</div>";
                      echo "<div  style = 'display:inline;'>";
                      echo "<h4 style = 'display:inline; margin-top:10px; margin-left:5px;'>".$getbackdata2['Fullname']."</h4>";
                      echo "</div>";
                      echo "</div></a>";
                    }
                    
                    if($limit >= 2){
                        break;
                    }
                    $limit++;
                  }
                  echo "<div style = 'margin:5px 0px; display:block; text-align:center;'><a href = 'chatlist.php'>See All Friends</a></div> ";
                  echo "<div style = 'margin:10px;' class = 'alert alert-success'>Get More Friends On ChatFlow<br/>Search Here<form style = 'margin: 10px;' action = 'search.php' method = 'get'>
                  <input style = 'margin: 2px 10px 2px 0px;' class = 'form-control' type = 'search' name = 'q' placeholder = 'Search Friends...' />
                  <input type = 'submit' value = 'Search' class = 'btn btn-primary' />
              </form></div>";
              }
        
        ?>
    </div>
    <style>
	 .anchors:hover{
		text-decoration:none;
	 }
	 .rows:hover{
		 background-color:#eee;
		 border-radius: 5px;
	 }
	 .rows{
			font-family: Verdana,sans-serif;
	 }
	</style>
</body>

</html>