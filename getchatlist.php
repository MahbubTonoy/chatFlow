<?php require "connectscript.php"; ?>
<?php
				$currentusr = $_COOKIE['user'];
  			$sqlcom = "SELECT DISTINCT sender_suname, receiver_suname, dateofmsg FROM msgs WHERE sender_suname = '$currentusr' OR receiver_suname = '$currentusr' ORDER BY dateofmsg DESC;";
				$runsql = mysqli_query($dbconnect,$sqlcom);
				if(mysqli_num_rows($runsql) == 0){
					echo "<style> .get-frnd-div-green {display:none;} .get-frnd-div-yellow {display:block;}</style>";
				} else {
					echo "<div style = 'padding:10px 0px 0px 0px; margin-bottom:10px; border-bottom: 1px solid #999;'><h3>Recent Chat's</h3></div>";

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
							echo "<a class = 'anchors' style = 'color:#333;' href = 'chatflow.php?msgid=$getsuname2' ><div style = 'margin:0px 0px;padding: 5px 0px; border-bottom:1px solid #eee; padding:15px;' class = 'row read".$getsuname2."' >"; 
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
									//echo $getname;
									$sqlcom = "SELECT content, sender_suname, dateofmsg,stat FROM msgs WHERE (sender_suname = '$getname' AND receiver_suname = '$currentusr') OR (sender_suname = '$currentusr' AND receiver_suname = '$getname') ORDER BY dateofmsg DESC LIMIT 1;";
									$runsql = mysqli_query($dbconnect,$sqlcom);
									$fetch = mysqli_fetch_array($runsql);
									$retmsg = $fetch['content'];
									echo "<div style = 'margin-left:5px;display:block; color:#777; font-size: 16px;' ><i>$retmsg</i></div>";
									if($fetch['stat'] != 'seen' && $fetch['sender_suname'] != $currentusr ){
                    echo "";
										echo "<style>
										.read".$getsuname2."{
											background-color: #eef5ff;
										}
										.read".$getsuname2." h4{
											
											border-radius: 5px;
										}
										.read".$getsuname2." h4::after{
											content: ' ●';
											color:#0069d9;
										}
										</style>";
									}
								echo "</div>";
							echo "</div></a>";
							 
						}
						if($item['receiver_suname'] == "$currentusr" ){
							$getname = $item['sender_suname'];
							$sqlcom2 = "SELECT Fullname, DP, ID, SUname FROM userdata WHERE SUname = '$getname';";
							$runsql2 = mysqli_query($dbconnect,$sqlcom2);
							$getbackdata2 = mysqli_fetch_assoc($runsql2);
							$getsuname2 = $getbackdata2['SUname'];
							echo "<a class = 'anchors' style = 'color:#333;' href = 'chatflow.php?msgid=$getsuname2' ><div style = 'margin:0px 0px;padding: 5px 0px; border-bottom:1px solid #eee; padding:15px;' class = 'row read".$getsuname2."' >";
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
									$sqlcom = "SELECT sender_suname, content, dateofmsg, stat FROM msgs WHERE (sender_suname = '$getname' AND receiver_suname = '$currentusr') OR (sender_suname = '$currentusr' AND receiver_suname = '$getname') ORDER BY dateofmsg DESC LIMIT 1;";
									$runsql = mysqli_query($dbconnect,$sqlcom);
									$fetch = mysqli_fetch_array($runsql);
									$retmsg = $fetch['content'];
									echo "<div style = 'margin-left:5px;display:block; color:#777; font-size: 16px;' ><i>$retmsg</i></div>";
									if($fetch['stat'] != 'seen' && $fetch['sender_suname'] != $currentusr){
										echo "<style>
										.read".$getsuname2."{
											background-color: #eef5ff;
										}
										.read".$getsuname2." h4{
											
											border-radius: 5px;
										}
										.read".$getsuname2." h4::after{
											content: ' ●';
											color:#0069d9;
										}
										</style>";
									}
								echo "</div>";
							echo "</div></a>";
						}
					}
					echo "<style> .get-frnd-div-green {display:block;} .get-frnd-div-yellow {display:none;}</style>";
				}
  			
			?>