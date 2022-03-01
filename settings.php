<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings | ChatFlow.Com</title>
    <?php require "logouter.php"; ?>
    <?php require "connectscript.php"; ?>
    <?php require "bootstrap.php"; ?>
    <?php require "header.php"; ?>
    <?php require "securedata.php"; ?>
</head>
<style>
    .header {
        background-color: #dbf5ff;
    }

    .mainbody {
        padding: 30px;
    }
</style>
<body>
    <?php
    $fname = $lname = $cnoutpt = $usrpwd = $rpalrt = $oldpswrn = $newps1wrn = $newps2wrn = "";
    $getcookies = $_COOKIE['user'];
    $sqlcom = "SELECT Fname, Lname FROM userdata WHERE SUname = '$getcookies'";
    $runquery = mysqli_query($dbconnect, $sqlcom);
    $fetchingdata = mysqli_fetch_assoc($runquery);
    $fname = $fetchingdata["Fname"];
    $lname = $fetchingdata["Lname"];
    ?>
    <div class="container">
        <div class="header container">
            <?php require "navbar.php"; ?>
        </div>
        <div class="mainbody row">
            <div class="col-sm-12">
                <h3>General Settings:</h3>
            </div>
            <div class="col-sm-5 colleft">
                Change Name:
            </div>
            <div class="col-sm-7 colright">
                <?php
                if (isset($_REQUEST['namechange'])) {
                    if (isset($_REQUEST['usrpwd'])) {
                        $usrpwd = msec($_REQUEST['usrpwd']);
                        $sqlcom = "SELECT Pwd FROM userdata WHERE SUname = '$getcookies'";
                        $runsql = mysqli_query($dbconnect, $sqlcom);
                        $Pwd = mysqli_fetch_assoc($runsql);
                        if ($Pwd['Pwd'] == md5($usrpwd)) {
                            $fname = msec($_REQUEST['fname']);
                            $lname = msec($_REQUEST['lname']);
                            $fullname = $fname . " " . $lname;
                            $sqlcom = "UPDATE userdata SET Fname = '$fname', Lname = '$lname', Fullname = '$fullname' WHERE SUname = '$getcookies'";
                            $runsql = mysqli_query($dbconnect, $sqlcom);
                            if (!$runsql) {
                                die("System Error: " . mysqli_error($dbconnect));
                            } else {
                                $cnoutpt = "<div class = 'alert alert-success'>Your Name Has Been Changed Successfully<br/>You May Reload This Page To See The Result.</div>";
                            }
                        } else {
                            $rpalrt =  "<div class = 'alert alert-danger'>Your Password is Incorrect.<br/>Please Try Again.</div>";
                        }
                    }
                }
                $sqlcom = "SELECT Fname, Lname FROM userdata WHERE SUname = '$getcookies'";
                $runquery = mysqli_query($dbconnect, $sqlcom);
                $fetchingdata = mysqli_fetch_assoc($runquery);
                $fname = $fetchingdata["Fname"];
                $lname = $fetchingdata["Lname"];
                ?>
                <form action="<?php echo msec($_SERVER['PHP_SELF']) . '?namechange'; ?>" method="POST">
                    <input type="password" class="form-control" value="<?php echo $usrpwd; ?>" name="usrpwd" placeholder="Your Password" /><br />
                    <?php echo $rpalrt; ?>
                    <input type="text" class="form-control" value="<?php echo $fname; ?>" name="fname" placeholder="First Name" /><br />
                    <input type="text" class="form-control" value="<?php echo $lname; ?>" name="lname" placeholder="Last Name" /><br />
                    <input type="submit" class="btn btn-outline-primary" value="Change Name" /><br /><br />
                    <?php echo $cnoutpt; ?>
                </form>
            </div>
            <hr style="width: 100%; height: 1px;" />
            <div class="col-sm-5 colleft">
                Change Password:
            </div>
            <div class="col-sm-7 colright">
                <?php
                    $temppw = $cnpt =  "";
                    if (isset($_REQUEST['changepass'])) {
                        if (isset($_REQUEST['oldpass']) && isset($_REQUEST['newpass1']) && isset($_REQUEST['newpass2'])) {
                            $oldpass = msec($_REQUEST['oldpass']);
                            $newpass1 = msec($_REQUEST['newpass1']);
                            $newpass2 = ($_REQUEST['newpass2']);
                            $sqlcom = "SELECT Pwd FROM userdata WHERE SUname = '$getcookies'";
                            $runsql = mysqli_query($dbconnect, $sqlcom);
                            $getdata = mysqli_fetch_assoc($runsql);
                            if (empty($oldpass)) {
                                $oldpswrn = "<div class = 'alert alert-danger'>You Can't Let This Field Empty.</div>";
                            } else {
                                if ($getdata['Pwd'] == md5($oldpass)) {
                                    if (empty($newpass1)) {
                                        $newps1wrn  = "<div class = 'alert alert-danger'>You Can't Let This Field Empty.</div>";
                                    } else {
                                        if (strlen($newpass1) < 8) {
                                            $newps1wrn  = "<div class = 'alert alert-danger'>Your New Password Is Less Then Eight Digit's.<br/>Please Try Again.</div>";
                                        } else {
                                            $temppw = $newpass1;
                                        }
                                    }
                                    if (empty($newpass2)) {
                                        $newps2wrn  = "<div class = 'alert alert-danger'>You Can't Let This Field Empty.</div>";
                                    } else {
                                        if (strlen($newpass2) < 8) {
                                            $newps2wrn  = "<div class = 'alert alert-danger'>Your Confirmation Password Is Less Then Eight Digit's.<br/>Please Try Again.</div>";
                                        } else {
                                            if ($newpass2 == $temppw) {
                                                $updatepass = md5($newpass2);
                                                $sqlcom = "UPDATE userdata SET Pwd = '$updatepass' WHERE SUname = '$getcookies'";
                                                $runsql = mysqli_query($dbconnect, $sqlcom);
                                                if (!$runsql) {
                                                    $cnpt = "<div class = 'alert alert-danger'>Could Not Update Data: " . mysqli_error($dbconnect) . "<br/>Please Try Again.</div>";
                                                } else {
                                                    $cnpt  = "<div style = 'margin-top: 10px;' class = 'alert alert-success'>Your Password Has Been Changed Successfully.</div>";
                                                }
                                            } else {
                                                $newps2wrn  = "<div class = 'alert alert-danger'>Your Confirmation Password Is Not Matched With New Password.<br/>Please Try Again.</div>";
                                            }
                                        }
                                    }
                                } else {
                                    $oldpswrn = "<div class = 'alert alert-danger'>Your Old Password is Incorrect.<br/>Please Try Again.</div>";
                                }
                            }
                        }
                    }
                ?>
                <form action="<?php echo msec($_SERVER['PHP_SELF']) . "?changepass"; ?>" method="POST">
                    <input type="password" class="form-control" name="oldpass" placeholder="Enter Old Password" /><br />
                    <?php echo $oldpswrn; ?>
                    <input type="password" class="form-control" name="newpass1" placeholder="Enter New Password (Min 8 Digits)" /><br />
                    <?php echo $newps1wrn; ?>
                    <input type="password" class="form-control" name="newpass2" placeholder="Confirm New Password (Min 8 Digits)" /><br />
                    <?php echo $newps2wrn; ?>
                    <input type="submit" class="btn btn-outline-primary" value="Change Password" />  <a style=" margin-top: 10px ; padding-left: 15px" onclick = "alert('Currently Not Available'); return false;" href="#">Forgot Password?</a>
                    <?php echo $cnpt; ?>
                </form>
            </div>
            <hr style="width: 100%; height: 1px;" />
            <div class="col-sm-5 colleft">
                Change Birth Date:
            </div>
            <div class="col-sm-7 colright">
                <?php
                $datemsg = "";
                if (isset($_REQUEST['changebdate'])) {
                    if (empty($_REQUEST['newdate'])) {
                        $datemsg  = "<div class = 'alert alert-danger'>You Can't Let This Field Empty.</div>";
                    } else {
                        $getdate = msec($_REQUEST['newdate']);
                        $sqlcom = "UPDATE userdata SET DOB = '$getdate' WHERE SUname = '$getcookies'";
                        $runsql = mysqli_query($dbconnect, $sqlcom);
                        if (!$runsql) {
                            $datemsg  = "<div class = 'alert alert-danger'>Error Updating Date: " . mysqli_error($dbconnect) . "</div>";
                        } else {
                            $datemsg  = "<div class = 'alert alert-success'>Your Password Has Been Changed Successfully.</div>";
                        }
                    }
                }
                ?>
                <form action="<?php echo msec($_SERVER['PHP_SELF']) . '?changebdate'; ?>" method="POST">
                    <input type="date" name="newdate" class="form-control" /><br />
                    <input type="submit" value="Change Birth Date" class="btn btn-outline-primary" />
                    <?php echo $datemsg; ?>
                </form>
            </div>
            <hr style="width: 100%; height: 1px;" />
            <div class="col-sm-5 colleft">
                Change Gender:
            </div>
            <div class="col-sm-7 colright">
                <?php
                $gnmsg = '';
                if (isset($_REQUEST['changegen'])) {
                    if (isset($_REQUEST['gender'])) {
                        $getgen = $_REQUEST['gender'];
                        if ($getgen == "none" || $getgen == "") {
                            $gnmsg = "<div class = 'alert alert-danger'>You Can't Let This Field Empty.</div>";
                        } else {

                            $sqlcom = "UPDATE userdata SET Gender = '$getgen' WHERE  SUname = '$getcookies'";
                            $runsql = mysqli_query($dbconnect, $sqlcom);
                            if (!$runsql) {
                                $gnmsg = "<div class = 'alert alert-danger'>Something Error: " . $mysqli_error($dbconnect) . "</div>";
                            } else {
                                $gnmsg = "<div class = 'alert alert-success'>Your Gender Has Been Changed Successfully.</div>";
                            }
                        }
                    }
                }
                ?>
                <form action="<?php echo msec($_SERVER['PHP_SELF']) . '?changegen'; ?>" method="post">
                    <select class="form-control" name='gender'>
                        <option value="none">Choose One...</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select><br />
                    <input type="submit" value="Change Gender" class="btn btn-outline-primary" /><br /><br />
                    <?php echo $gnmsg; ?>
                </form>
            </div>
            <!-- main body end-->
        </div>
    </div>

</body>

</html>