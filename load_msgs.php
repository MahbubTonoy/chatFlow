  <div id = "tophead">
    <noscript>
      <div class = 'alert alert-danger'>
        <b>Change Your Browser! </b><br/>
        This Browser is No longer able to Handle This Page.<br/><br/>
        <i><u>Solutions:</u></i>
        <ul>
          <li>Turn On Javascript From Settings Then Refresh This Page.</li>
          <li>Check For The Latest Version of Your Browser.</li>
          <li>Try Different Browser.</li>
        </ul>
      </div>
    </noscript>
  </div>
  
  <?php
    if(isset($_COOKIE['msgnum']) ){
      $msgcount = $_COOKIE['msgnum'];
    } else {
      $msgcount = 15;
    }
  require "connectscript.php";
  if(isset($_REQUEST['msgid'])){
    $localuser = $_COOKIE['user'];
    $forignuser = $_REQUEST['msgid'];
    $sqlcom = "SELECT * FROM msgs WHERE (sender_suname = '$localuser' AND receiver_suname = '$forignuser') OR (sender_suname = '$forignuser' AND receiver_suname = '$localuser')  ORDER BY ID DESC LIMIT $msgcount;";
    $runsql = mysqli_query($dbconnect, $sqlcom);
    if(mysqli_num_rows($runsql) == 0){
      $getid = $_REQUEST['msgid'];
      $sqlcom = "SELECT Fname FROM userdata WHERE SUname = '$getid';";
      $runsql = mysqli_query($dbconnect, $sqlcom);
      $getdata = mysqli_fetch_assoc($runsql);
      echo "<div style = 'text-align:center; color: #999; '><small>Welcome To ChatFlow.<br/>Be First To Start Conversation With ".$getdata['Fname']." </small></div>";
    } else {
      //more msg loader
      $sqlcomload = "SELECT * FROM msgs WHERE (sender_suname = '$localuser' AND receiver_suname = '$forignuser') OR (sender_suname = '$forignuser' AND receiver_suname = '$localuser')";
      $runsqlload = mysqli_query($dbconnect, $sqlcomload);
      if(mysqli_num_rows($runsqlload) >= 16 && mysqli_num_rows($runsqlload) > $msgcount ){
        echo "<div style = 'text-align:center;' id = 'loadingcontainer'><img id = 'loadimgid' style = 'display:none;' src = 'images/system/loading.svg' height = '30px' /><a id = 'loadmsgs' onclick = 'loadmore()' style = 'color: #09f;' href = '#'>Load More Messages</a></div>";
      }
      while($mydata = mysqli_fetch_assoc($runsql)){
        $items[] = $mydata;
      }
      $items = array_reverse($items, true);
      
      foreach($items as $item){
        if($item['sender_suname'] == $localuser && $item['receiver_suname'] == $forignuser){
          if($item['imgs'] == "N/A"){
            $content = $item['content'];
            echo "<div style = 'margin:5px 10px 0px 0px; padding: 10px; border-radius: 10px 10px 0px 10px; max-width: 80%; background-color: #007ACC; color: white; float:right;'>$content</div><div style = 'clear:both;margin:0px;padding:0px;'></div>";
          } else {
            $imgs = $item['imgs'];
            echo "<a href = 'images/cf/$imgs' download><img src = 'images/cf/$imgs' style = 'border-radius: 10px; border:1px solid #ddd;margin:5px 10px 0px 0px; max-height:150px; max-width:60%; float: right;' /></a><div style = 'clear:both;margin:0px;padding:0px;'></div>";
          }
          
        }
        if($item['receiver_suname'] == $localuser && $item['sender_suname'] == $forignuser){
          if($item['imgs'] == "N/A"){
            $content = $item['content'];
            echo "<div style = 'margin:10px 0px 0px 10px; padding: 10px; border-radius: 10px 10px 10px 0px; max-width: 80%; background-color: #eee; color: #333333; float:left;'>$content</div><div style = 'clear:both; margin:0px;padding:0px;'></div>";
          } else {
            $imgs = $item['imgs'];
            echo "<a href = 'images/cf/$imgs' download><img src = 'images/cf/$imgs' style = 'border-radius: 10px;border:1px solid #ddd;margin:10px 0px 0px 10px; max-height:150px; max-width: 60%; float:left' /></a><div style = 'clear:both;margin:0px;padding:0px;'></div>";
          }
          
        }
      }
      $sqlcomseen = "SELECT * FROM msgs WHERE (sender_suname = '$localuser' AND receiver_suname = '$forignuser') OR (sender_suname = '$forignuser' AND receiver_suname = '$localuser') ORDER BY ID DESC LIMIT 1;";
      $runsqlseen = mysqli_query($dbconnect, $sqlcomseen);
      while($mydataseen = mysqli_fetch_assoc($runsqlseen) ){
        if($mydataseen['stat'] == "seen" && $mydataseen['sender_suname'] == $_COOKIE['user'] ){
          echo "<div style = 'margin:2px 10px 2px 0px;' class = 'float-right text-secondary'>Seen <i class='fas fa-check-square'></i></div> ";
          echo "<div style = 'clear:both'></div>";
        }
      }
    }
  } else {
    header("location: chatlist.php");
  }
  ?>
  <div style = "color:#999;font-size:1em;float:right;padding:5px;" id = 'statID'></div>
  <div style = 'clear:both;'></div>
  <?php
  ?>
  <div id = "loadings">
  </div>
