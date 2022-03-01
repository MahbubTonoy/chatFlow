<?php
require 'securedata.php';
if (isset($_COOKIE['user']) && isset($_COOKIE['secdats'])) {
    header('location: index.php');
}
?><?php
  $luname = $lpw = $rfn = $rln = $run = $rmail = $rpw = $rpw2 = $rgndr = $rbdate = $ragree = $reginformation = $logininformation = "";
?><?php
    //regestration error msg
    if (isset($_REQUEST['ref'])) {
      if(msec($_REQUEST['ref']) == "reg"){
        if (empty(msec($_REQUEST['fname']))) {
          $rfn = '<span class="firstnameinfoshow">First Name is Required.</span>';
      } else {
          $regfn = msec($_REQUEST['fname']);
          //echo $regfn."<br/>";
          //main firstname
      }
      if (empty(msec($_REQUEST['lname']))) {
          $rln = '<span class="lastnameinfoshow">Last Name is Required.</span>';
      } else {
          $regln = msec($_REQUEST['lname']);
          //main last name
          // echo $regln."<br/>";

      }
      if (empty(msec($_REQUEST['reguname']))) {
          $run = '<span class="usernameinfoshow">Username is Required.</span>';
      } else {
          $regusrstr =  strtolower(preg_replace('/\s+/', '', msec($_REQUEST['reguname'])));
          //main username
          // echo $regusrstr."<br/>";
      }
      if (empty(msec($_REQUEST['mail']))) {
          $rmail = '<span class="emailinfoshow">Email is Required.</span>';
      } else {
          if (filter_var(msec($_REQUEST['mail']), FILTER_VALIDATE_EMAIL)) {
              $regmail = msec(filter_var($_REQUEST['mail'], FILTER_SANITIZE_EMAIL));
              //main email
              // echo $regmail."<br/>";
          } else {
              $rmail = '<span class="emailinfoshow">Your Email is Not Valid.</span>';
          }
      }
      if (empty(msec($_REQUEST['regpow1']))) {
          $rpw = '<span class="passwordinfoshow2">Password is Required.</span>';
          $temppw = 0;
      } else {
          if (strlen(msec($_REQUEST['regpow1'])) <= 7) {
              $rpw = '<span class="passwordinfoshow2">Eight Digit Or Longer Password Required.</span>';

              $temppw = 0;
          } else {
              $temppw = msec($_REQUEST['regpow1']);
          }
      }
      if (empty(msec($_REQUEST['regpow2']))) {
          $rpw2 = '<span class="passwordinfoshow2">Password Confirmation is Required.</span>';
      } else {
          if (strlen(msec($_REQUEST['regpow2'])) < 7) {
              $rpw2 = '<span class="passwordinfoshow2">Eight Digit Or Longer Password Required.</span>';
          } else {
              if ($temppw == msec($_REQUEST['regpow2'])) {
                  $regpassstr = md5(msec($_REQUEST['regpow2']));
                  //main pw on hash
                  // echo $regpassstr."<br/>".msec($_REQUEST['regpow2'])."<br/>";
              } else {
                  $rpw2 = '<span class="passwordinfoshow2">Password Doesn\'t Match.</span>';
              }
          }
      }
      if (empty(msec($_REQUEST['gender']))) {
          $rgndr = '<span class="genderinfoshow">Selecting Gender is Required.</span>';
      } else {
          $reggndrstr = msec($_REQUEST['gender']);
          //main gender
          // echo $reggndrstr."<br/>";

      }
      if (empty(msec($_REQUEST['birthdate']))) {
          $rbdate = '<span class="birthdayinfoshow">Your Birth Date is Required.</span>';
      } else {
          $regbdatestr = msec($_REQUEST['birthdate']);
          //main birthdate
          // echo $regbdatestr."<br/>";

      }
      if (!isset($_REQUEST['regterms'])) {
          $ragree = '<span style = "display: block;" class="termsinfoshow">Your Agreement is Required.</span>';
      } else {
          $regagree = msec($_REQUEST['regterms']);
          //main agreement
          //echo $regagree."<br/>";

      }
      }
        
    }
    ?><?php
    //$regfn = $regln =  $regusrstr  = $regmail =  $regpassstr  = $reggndrstr =  $regbdatestr =  $regagree = "";
    //$regfn   $regln   $regusrstr   $regmail   $regpassstr   $reggndrstr   $regbdatestr   $regagree;
    require "connectscript.php";
    if (isset($regfn) && isset($regln) && isset($regusrstr) && isset($regmail) && isset($regpassstr) && isset($reggndrstr) && isset($regbdatestr) && isset($regagree) && msec($_REQUEST['ref']) == "reg") {



        if ($dbconnect != false) {
            $dbcheckuser = "SELECT * FROM userdata WHERE Username = '$regusrstr'";
            $dbcheckmail = "SELECT * FROM userdata WHERE Email = '$regmail'";
            $runusercheck = mysqli_query($dbconnect, $dbcheckuser);
            $runmailcheck = mysqli_query($dbconnect, $dbcheckmail);
            if (mysqli_num_rows($runusercheck) > 0) {
                $run = '<span class="usernameinfoshow">This Username Has Been Taken.</span>';
            }
            if (mysqli_num_rows($runmailcheck) > 0) {
                $rmail = '<span class="emailinfoshow">This Email Has Been Taken.</span>';
            } else {
              
                $regip = $_SERVER['REMOTE_ADDR'];
                $regfull = $regfn . " " . $regln;
                $dbquery = "INSERT INTO userdata(Username,SUname, XSUname, Fname, Lname, Fullname, Email, Pwd, Gender, DOB,Signup_date, IP) VALUES('$regusrstr',md5('$regusrstr'),md5(md5(md5('$regusrstr'))),'$regfn','$regln','$regfull','$regmail','$regpassstr','$reggndrstr','$regbdatestr',CURRENT_TIMESTAMP, '$regip')";
                $_rquery = mysqli_query($dbconnect, $dbquery);
                $reginformation = "<div class = 'container' style = 'background-color:#dcffe4; padding: 20px; color: #606060'>Your Account Has Been Created Successfully. Please Log In To Continue</div>";
                setcookie("user", MD5($regusrstr), time() + (86400 * 2), "/");
                //setcookieone("user", MD5($regusrstr), time() + (86400 * 2), "/");
                setcookie("secdats", md5(md5(md5($regusrstr))), time() + (86400 * 2), "/");
                //setcookietwo("secdats", md5(md5(md5($regusrstr))), time() + (86400 * 2), "/");
                header("location: profile.php");
                //headerone("profile.php");
                if ($_rquery == false) {
                    //echo mysqli_error($dbconnect);
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Welcome To <?php require "sitename.php"; ?></title>
  <link rel="stylesheet" href="stylesheets/reset.css" type="text/css" />
  <link rel="stylesheet" href="stylesheets/main.css" type="text/css" />
  <link rel="icon" href="images/system/favicon.ico" type="image/gif">
  <script type="text/javascript" src="javascript/consolemsg.js"></script>
  <!-- Bootstrap-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>

  <style>
    .hovermsg span {
      color: red;
    }
  </style>
</head>

<body>
<?php
  if(isset($_REQUEST['error'])){
    if($_REQUEST['error']==403){
      echo '<div class = "alert alert-danger" style = "margin:0px;" >Something Went Wrong! You Are Trying To Access A Page That Are Not Accessable To The Users. <a href = "#">Learn More</a></div>';
    }
  }
  ?>
  <div class="header container">
    <a href="index.php">
      <div class="col-md-6 logodiv">
        <?php require "logo.php" ?>
      </div>
    </a>
    <div class="col-md-4 loginform">
      <h4>Log In:</h4>
      <form action="login_reg_core.php?ref=login" method="POST">
        <div class="hovermsg usermsg">
          <div class="form-group">
            <input class="form-control" id="usr" type="text" name="uname" placeholder="Username" />
            <!--required-->
            <?php //echo $luname; ?>
          </div>
        </div>

        <div class="hovermsg passmsg">
          <div class="form-group">
            <input class="form-control" type="password" name="loginpassword" placeholder="Password (Min 8 Digit)" />
            <!--required-->
            <?php //echo $lpw ?>
          </div>

        </div>
        <?php 
          if(isset($_REQUEST['error'])){
            if($_REQUEST['error']==1){
              echo '<div class = "alert alert-danger">Email And Password is Required!</div>';
            }
            if($_REQUEST['error']==404){
              echo '<div class = "alert alert-danger">Sorry, We could Not Found Any Account With Your Information.<br/><a href = "#reg">Create New Account</a> </div>';
            }
            if($_REQUEST['error']==2){
              echo '<div class = "alert alert-danger">Something is Wrong With Your Account. Please Contact With <a href = "https://www.facebook.com/ThizIztonoy">Admin</a></div>';
            }
          }
        ?>
        <input class="btn btn-primary" style="margin-right: 10px" type="submit" value="Log In" /> <a href="#"
          onclick="alert('Currently Not Available'); return false;" title="Forgot Password">Forgot Password</a>
      </form>

    </div>
    <div style="clear:both;"></div>
  </div>


  <?php echo $reginformation; ?>
  <div class="middle container" id = "reg">

    <div class="create col-md-12">
      <h3>Create New Account</h3>

      <form action="<?php echo msec($_SERVER['PHP_SELF']); ?>?ref=reg" method="post">
        <div class="hovermsg fnamemsg">
          <div class="form-group">
            <input class="form-control" type="text" name="fname" placeholder="First Name" />
            <!--required-->
            <?php
              echo $rfn;
            ?>
          </div>
        </div>
        <div class="hovermsg lnamemsg">
          <div class="form-group">
            <input class="form-control" type="text" name="lname" placeholder="Last Name" />
            <!--required-->
            <?php
               echo $rln;
            ?>
          </div>
        </div>
        <div class="hovermsg lnamemsg">
          <div class="form-group">
            <input class="form-control" type="text" name="reguname" placeholder="Choose Username" />
            <!--required-->
            <?php
              echo $run;
            ?>
          </div>
        </div>
        <div class="hovermsg passmsg">
          <div class="form-group">
            <input class="form-control" type="email" name="mail" placeholder="Email" />
            <!--required-->
            <?php
              echo $rmail;
            ?>
          </div>
        </div>

        <div class="hovermsg passmsg2">
          <div class="form-group">
            <input class="form-control" type="password" name="regpow1" placeholder="Password (Minimum 8 Digit)" />
            <!--required-->
            <?php
              echo $rpw;
            ?>
          </div>

        </div>

        <div class="hovermsg passmsg3">
          <div class="form-group">
            <input class="form-control" type="password" name="regpow2" placeholder="Confirm Password" />
            <!--required-->
            <?php
              echo $rpw2;
            ?>
          </div>

        </div>

        <div class="hovermsg gendermsg">
          <div class="form-group">
            <label for="sel1">Gender:</label>
            <select class="form-control" id="sel1" name="gender">
              <!--required-->
              <option value="">Plesase Select...</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
            <?php
              echo $rgndr;
            ?>
          </div>
        </div>

        <div class="hovermsg birthmsg">
          <div class="form-group">
            <label>Birth Date:</label>
            <input class="form-control" type="date" name="birthdate" placeholder="Your Birthday" />
            <!--required-->
            <?php
              echo $rbdate;
            ?>
          </div>
        </div>
        <div class="hovermsg termsmsg">
          <div class="form-check">
            <label class="form-check-input"><input type="checkbox" name="regterms" />
              <!--required--> I am Agree With The Terms And Conditions And The Cookie Policy.<br /></label>
            <br /><?php
              echo $ragree;
            ?>
          </div><br />

        </div>
        <input class="btn btn-primary" type="submit" value="Create Account" />
        <br />
        <br />
      </form>
    </div>
    <!--<div class = "rightform col-xl-2">
            Hello World
        </div>-->

  </div>
  <div class="footer container">
    Copyright <?php echo date("Y") ?> &copy; <?php require "sitename.php"; ?><br /> All Rights Reserved
  </div>
</body>


</html>