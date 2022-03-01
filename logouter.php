<?php require "connectscript.php"; ?>
<?php
if (isset($_COOKIE['user']) && isset($_COOKIE['secdats']) ) {
    $indexvalue = $_COOKIE['user'];
    $indexvaluesec = $_COOKIE['secdats'];
    $indexquery = "SELECT * FROM userdata WHERE SUname='$indexvalue' AND XSUname = '$indexvaluesec' ";
    $indexrun = mysqli_query($dbconnect, $indexquery);
    $indexrows = mysqli_num_rows($indexrun);
    if ($indexrows != 1) {
        header("location: login.php?error=true&errorno=404");
    } else {
        $setip = $_SERVER['REMOTE_ADDR'];
        $sqlcom = "UPDATE userdata SET IP = '$setip' WHERE SUname = '$indexvalue'";
        mysqli_query($dbconnect, $sqlcom);
    }
} else {
    header("location: login.php?logout=true");
}
?>