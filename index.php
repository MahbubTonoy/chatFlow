<?php
require "connectscript.php";
if (isset($_COOKIE['user'])) {
    $indexvalue = $_COOKIE['user'];
    $indexquery = "SELECT * FROM userdata WHERE SUname='$indexvalue' ";
    $indexrun = mysqli_query($dbconnect, $indexquery);
    $indexrows = mysqli_num_rows($indexrun);
    if ($indexrows == 1) {
        header("location: profile.php");
    } else {
       header("location: login.php?error=true&errorno=1");
    }
} else {
    header("location: login.php");
}
require "header.php"; ?>