<?php require "logouter.php"; ?>
<?php setcookie("msgnum", 15, time() + (86400 * 2), "/"); ?>
<?php
    if(isset($_REQUEST["msgid"])){
      if($_REQUEST["msgid"] != $_COOKIE['user']){
        if(empty($_REQUEST["msgid"]) ){
          header("location: chatlist.php");
        } else {
          $getid = $_REQUEST['msgid'];
          $sqlcom = "SELECT Fullname FROM userdata WHERE SUname = '$getid';";
          $runsql = mysqli_query($dbconnect, $sqlcom);
          $getdata = mysqli_fetch_assoc($runsql);
        }
      } else {
        header("location: chatlist.php");
      }
      
    } else {
      header("location: chatlist.php");
    }
  ?>
<!DOCTYPE html>
<html lang="en" style = "height: 100%;">
<head>
<?php require "connectscript.php"; ?>
<?php require "securedata.php";?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $getdata['Fullname']; ?> | ChatFlow</title>
  <script src="https://kit.fontawesome.com/113ecb3cb4.js" crossorigin="anonymous"></script>
  <?php require "header.php"; ?>
  <?php require "bootstrap.php"; ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <script src="javascript/symbols.js"></script>
  <script src="javascript/emoticon.js"></script>

</head>
<body style = "height: 100%;overflow-y:hidden;" id = "bodyID" onresize= "sizematters()" onload = "sizematters()">

  <div class = "container" style = "position:relative;" id = "containerfullID">
    <div id = "header" class = "header" style = "margin:auto; width: 100%; position:absolute; z-index: 999; top:0px;">
      <?php require "navbar.php"; ?>
    </div>
    <div style = "clear:both;"></div>
    <div class = "msgbody" style = "padding-top: 60px;position:absolute; top: 0px; bottom: 0px; width: 100%;" id = "msgbodyid">

        <div id = "fnameid" class = "position-sticky" style = "padding-bottom: 10px;margin: 10px; border-bottom:1px solid #dddddd;"><h4 style = 'display:inline;'><?php echo $getdata['Fullname']; ?></h4><span id = 'activestatid' style = 'margin-left: 0.5em'><span style = 'font-size:small; color:#999;' >Checking Activity...</span></span></div>
        <div class = "msgs" style = "overflow-y:scroll;scrollbar-width: thin;" id = "scrollfix">
        <?php
          require "load_msgs.php";
        ?>
        </div>
      </div>
    </div>
    <div style = "clear:both;"></div>
    <div id = "formid" style = "margin: auto; position:absolute; bottom:0px; background:white; width: 100%;">
      <div class = "container" id = 'formcontid'>
        <form enctype = "multipart/form-data" onsubmit = "return false;" method = "post" id = "frmid">
          <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend"  style = 'position:relative;'>
              <span id = "timesid" onclick = "cutimg()" style = "cursor: pointer;position:absolute; z-index:999; color: #00ff00; display: none; margin: -3px 0px 0px 10px; font-size:35px; opacity: 0.8;"><i class="fas fa-check"></i></span>
              <span id = 'clipID' onclick = "uploadimg()" class="input-group-text"><i class="fas fa-paperclip"></i></span>
            </div>
            <style>
              #clipID:hover{
                background-color: #6c757d;
                color: #ddd;
                cursor: pointer;
              }
            </style>
            <script>
            function uploadimg() {
              document.getElementById("mainfileinp").click();
            }
            </script>
            <input style = 'display:none;' type = "file" id = 'mainfileinp' name = 'imgup' />
            <input autocomplete="off" type="text" onfocus = "hideicons()" onfocusout = "showicons()" class="form-control" placeholder="Type A Message..." aria-label="Recipient's message" aria-describedby="button-addon2" id = "stylemsgid"  />
            <div class="input-group-append">
              <button onclick = "updateScroll()" class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="far fa-paper-plane"></i></button>
            </div>
              <script>
                function hideicons() {
                  document.getElementById("clipID").style.display = "none";
                  document.getElementById("timesid").style.display = "none";
                  document.getElementById("stylemsgid").style.borderRadius = "10px 0px 0px 10px";
                }
                function showicons(){
                  document.getElementById("clipID").style.display = "block";
                  if(document.getElementById("mainfileinp").value != ""){
                    document.getElementById("timesid").style.display = "block";
                  }
                  document.getElementById("stylemsgid").style.borderRadius = "0px";
                }
              </script>
              <script>
                $(document).ready(function(){
                  $("#button-addon2").on("click",function(){
                    var stdID = "<?php echo $_COOKIE['user']; ?>";
                    var mesgID = escapeHtml(emoji($("#stylemsgid").val()));
                    var rtdID = "<?php echo msec($_REQUEST['msgid']); ?>";
                    fetch( "msgwithimgpros.php?recid=<?php echo $_REQUEST['msgid']; ?>&senid=<?php echo $_COOKIE['user'] ?>", {
                      method: "POST",
                      body: new FormData( document.getElementById("frmid")),
                      success: function(){
                        var element = document.getElementById("scrollfix");
                        element.scrollTop = element.scrollHeight;
                      }
                    });
                  //|| checkimgID != ""
                  var checkimgID = document.getElementById("mainfileinp").value;
                    if(mesgID != ""){
                      //console.log(checkimgID);
                      $.post("msgprocess.php", {getstdid: stdID, getmsgid: mesgID, getrtdid: rtdID}, function(retdata){
                        console.log(retdata);
                      if(retdata == "success"){
                        var element = document.getElementById("scrollfix");
                        element.scrollTop = element.scrollHeight;
                        document.getElementById("mainfileinp").value = null;
                        } else {
                          
                        }
                      });
                    } else {
                      if(checkimgID != ""){
                        document.getElementById("mainfileinp").value = null;
                        return false;
                      } else {
                        alert("You Can't Let This Field Empty!");
                      }
                      //console.log(checkimgID);
                    }
                    
                  document.getElementById("stylemsgid").value = "";
                });
              });
            </script>
          </div>
        </form>
      </div>
    </div>
    <script>
      function sizematters(){
        var h = window.innerHeight-200;
        var getid = document.getElementById("scrollfix");
        getid.style.height = h+"px";

        var element = document.getElementById("scrollfix");
        element.scrollTop = element.scrollHeight;


    var w = window.innerWidth;
    if(w <= 576){
      document.getElementById("containerfullID").style.width = "100%";
      document.getElementById("containerfullID").style.margin = "0px";
      document.getElementById("containerfullID").style.marginRight = "0px";
      document.getElementById("containerfullID").style.paddingLeft = "0px";
      document.getElementById("containerfullID").style.paddingRight = "0px";
      
      document.getElementById("formcontid").style.width = "100%";
      document.getElementById("formcontid").style.marginLeft = "0px";
      document.getElementById("formcontid").style.marginRight = "0px";
      document.getElementById("formcontid").style.paddingLeft = "0px";
      document.getElementById("formcontid").style.paddingRight = "0px";
    } else {
      document.getElementById("containerfullID").style.width = "";
      document.getElementById("containerfullID").style.marginLeft = "";
      document.getElementById("containerfullID").style.marginRight = "";
      document.getElementById("containerfullID").style.paddingLeft = "";
      document.getElementById("containerfullID").style.paddingRight = "";

      document.getElementById("formcontid").style.width = "";
      document.getElementById("formcontid").style.marginLeft = "";
      document.getElementById("formcontid").style.marginRight = "";
      document.getElementById("formcontid").style.paddingLeft = "";
      document.getElementById("formcontid").style.paddingRight = "";
    }
  }

</script>
<script>
  function updateScroll() {
    var element = document.getElementById("scrollfix");
    element.scrollTop = element.scrollHeight;
    setTimeout(setmytime, 2100);
    document.getElementById("loadings").innerHTML = '<div style = "margin:5px 10px 0px 0px; padding: 5px 10px 5px 10px; border-radius: 10px 10px 0px 10px; max-width: 80%; background-color: #009AEC; color: white; float:right;"><img src = "images/system/spinner.svg" height  = "30px" /> Sending...</div><div style = "clear:both;"></div>';
    //document.getElementById("mainfileinp").value = null;
    document.getElementById("timesid").style.display = "none";
  }
</script>
<script>
        //auto refresh
        function mkfresh(){
          <?php
            $getid = $_REQUEST['msgid'];
          ?>
          var tempval = "<?php echo $getid; ?>";
	        $("#scrollfix").load("load_msgs.php?msgid="+tempval+"&refr=1" , function(responseTxt){
            
          }).show();
          var rtdID = "<?php echo msec($_REQUEST['msgid']); ?>";
            $.post("msgstat.php", {stat: "seen", rec: rtdID}, function(retdata2){
              if(retdata2 == 'working'){
            }
          });


          var gettheid = '<?php if(isset($_REQUEST['msgid'])){echo $_REQUEST['msgid'];} ?>';
          $.post("stat_check.php",{getcom: gettheid}, function(getret){
            var theid = document.getElementById("activestatid");
            if(getret == "online" ){
              theid.innerHTML = "<span style = 'color:#00dd44'><i class='far fa-dot-circle'></i></<i> Online</span>";
            } else {
              theid.innerHTML = "<span style = 'color:#999'><font size = '0.5em'><i class='far fa-dot-circle'></i></font> Offline</span>";
              //console.log(getret);
            }
          });
        }
        setInterval(mkfresh, 2000);
        function setmytime(){
          var element = document.getElementById("scrollfix");
          element.scrollTop = element.scrollHeight;
        }
        
</script>
<?php $msgnum = $_COOKIE['msgnum']; ?>
  <script>
    function loadmore(){
      var loadimgid = document.getElementById("loadimgid");
      loadimgid.style.display = "inline";
      
      $.post("msgcount.php",{msginc:"true",msgnum:"<?php echo $msgnum; ?>"},function(){
      });
    }
  </script>
  <!-- id = 'mainfileinp' name = 'imgup' -->
  <script>
    var upid = document.getElementById("mainfileinp");
    upid.value  = "";
    document.getElementById("timesid").style.display = "none";
    var timeid = document.getElementById("timesid");
    upid.addEventListener("change", function(){
      if(upid != ""){
        timeid.style.display = "block";
        //console.log(upid.value);
      } else {
        timeid.style.display = "none";
      }
    });
  </script>

  <script>
    function cutimg(){
      document.getElementById("mainfileinp").value = "";
      document.getElementById("timesid").style.display = "none";
    }
  </script>
</body>
</html>