<?php require "logouter.php"; ?>
<?php //require "securedata.php"; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="my-nav-menu sticky-top" style = "background-color: #dbf5ff;">
    <nav class="navbar navbar-expand-lg my-nav-menu navbar-light">
        <?php require "logo-sm.php" ?>
        <button class="navbar-toggler red-dot" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent" style = "margin-left: 10px;">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link red-dot" href="chatlist.php">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="active_friends.php">Active Friends</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More Actions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" onclick = "alert('Survice Currently Not Available.');" href="#">Edit Profile</a>
                        <a class="dropdown-item" href="settings.php">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Log Out</a>
                    </div>
                </li>
            </ul>
            <?php
                //setcookie('hi','hi', time()+(244444), "/");
            ?>
            <form class="form-inline my-2 my-lg-0" action = "search.php" method = "get">
                <input class="form-control mr-sm-2" type="search" placeholder="Search Friends..." name = "q" aria-label="Search" value = "<?php if(isset($_REQUEST['q'])) { echo msec($_REQUEST['q']); }?>" >
                <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</div>
<script>
    $(document).ready(function(){
        setInterval(function(){
            user_stat();
        }, 5000);
      function user_stat(){
        $.ajax({
            
          url: "user_stat.php?getusr=<?php echo $_COOKIE['user'];  ?>",
          success: function() {
            
          }
        });
      }
    });
  </script>
<span id = 'auto_notif'>
<?php require "auto_notif.php"; ?>
</span>
<script>
    function auto_notif(){
        $("#auto_notif").load("auto_notif.php" , function(responseTxt){
            
        }).show();
    }
    setInterval(auto_notif, 1000);
</script>
<script>
function tune(){
    var getmine = "<?php echo $_COOKIE['user'] ?>";
    var tune = new Audio('assets/notification.wav');
    $.post('tune.php',{postdata:getmine}, function(retdata){
        if(retdata == "true"){
            tune.play();
            //console.log(retdata);
        } else {
            //console.log(retdata);
        }
    });
}
setInterval(tune, 1000);
</script>
