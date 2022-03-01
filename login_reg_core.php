<?php
require "connectscript.php";

if(isset($_REQUEST['ref'])){
  /////login
  if($_REQUEST['ref'] == "login"){
    if(isset($_REQUEST['uname']) && isset($_REQUEST['loginpassword']) ){
      $uname = $_REQUEST['uname'];
      $pass = $_REQUEST['loginpassword'];
      if(empty($uname) || empty($pass)){
        header("location: login.php?error=1");
      }else {
        $low = strtolower($uname);
        $secpass = md5($pass);
        $sqlcom = "SELECT * FROM userdata WHERE Username='$low' AND Pwd = '$secpass';";
        $query = mysqli_query($dbconnect, $sqlcom);
        $rows = mysqli_num_rows($query);
        if ($rows == 1) {
          // echo "working";
          setcookie("user", md5($low), time() + (86400 * 2), "/");
          setcookie("secdats", md5(md5(md5($low))), time() + (86400 * 2), "/");
          header("location: profile.php");
        }
        if($rows == 0){
          header("location: login.php?error=404");
        } else {
          header("location: login.php?error=2");
        }
      }
    } else {
      header("location: login.php?error=1");
    }
  }
  

  /////regestration
  if($_REQUEST['ref'] == 'reg'){
    if(isset($_REQUEST['fname']) && isset($_REQUEST['lname']) && isset($_REQUEST['reguname']) && isset($_REQUEST['mail']) && isset($_REQUEST['regpow1']) && isset($_REQUEST['regpow2']) && isset($_REQUEST['gender']) && isset($_REQUEST['birthdate']) && isset($_REQUEST['regterms'])){
      $fname = $_REQUEST['fname'];
      $lname = $_REQUEST['lname'];
      $uname = $_REQUEST['reguname'];
      $mail = $_REQUEST['mail'];
      $pass1 = $_REQUEST['regpow1'];
      $pass2 = $_REQUEST['regpow2'];
      $gender = $_REQUEST['gender'];
      $bdate = $_REQUEST['birthdate'];
      $terms = $_REQUEST['regterms'];
      /*
      echo $fname."<br/>";
      echo $lname."<br/>";
      echo $uname."<br/>";
      echo $mail."<br/>";
      echo $pass1."<br/>";
      echo $pass2."<br/>";
      echo $gender."<br/>";
      echo $bdate."<br/>";
      echo $terms."<br/>";*/
    } else {
      $err = "?error";
      if(!isset($_REQUEST['fname'])){
        //header("location: login.php?fnameerr");
        //$err .="&fnameerr";
      }
      if(!isset($_REQUEST['lname'])){
        //header("location: login.php?lnameerr");
        $err .="&lnameerr";
      }
      if(!isset($_REQUEST['reguname'])){
        //header("location: login.php?unameerr");
        $err .="&unameerr";
      }
      if(!isset($_REQUEST['mail'])){
        //header("location: login.php?mailerr");
        $err .="&mailerr";
      }
      if(!isset($_REQUEST['regpow1'])){
        //header("location: login.php?pass1err");
        $err .="&pass1err";
      }
      if(!isset($_REQUEST['regpow2'])){
        //header("location: login.php?pass2err");
        $err .="&pass2err";
      }
      if(!isset($_REQUEST['gender'])){
        //header("location: login.php?error=9");
        $err .="&gendererr";
      }
      if(!isset($_REQUEST['birthdate'])){
        //header("location: login.php?error=10");
        $err .="&bdateerr";
      }
      if(!isset($_REQUEST['regterms'])){
        //header("location: login.php?error=11");
        $err .="&agreeerr";
      }

      header("location: login.php$err");
    }
  }


} else {
  header("location: login.php?error=403");
}


/*/////regestration
if(isset($_REQUEST['ref'])){
  if(isset($_REQUEST['fname']) && isset($_REQUEST['lname']) && isset($_REQUEST['reguname']) && isset($_REQUEST['mail']) && isset($_REQUEST['regpow1']) && isset($_REQUEST['regpow2']) && isset($_REQUEST['gender']) && isset($_REQUEST['birthdate']) && isset($_REQUEST['regterms'])){
    echo "working";
  } else {
    header("location: login.php");
  }
}
*/


?>