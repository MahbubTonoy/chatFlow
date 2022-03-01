<?php
session_start();
?>
<?php

setcookie("user", "nonsense" , time()-5000, "/");
setcookie("secdats", "nonsense" , time()-5000, "/");
header("location: login.php");
?>