<?php require "connectscript.php"; ?>
<?php
  
    $me = $_COOKIE['user'];
    $sqlcom = "SELECT sender_suname, stat, dateofmsg FROM msgs WHERE receiver_suname = '$me' AND NOT stat = 'seen' ORDER BY dateofmsg DESC LIMIT 1;  ";
    $runsql = mysqli_query($dbconnect,$sqlcom);
    $num = mysqli_num_rows($runsql);
    if($num != 0){
      echo "<style>
      .red-dot::after{
        content:' ($num)';
        font-weight: bold;
        color: red;
      }
      </style>";
    }
  
  ?>
  