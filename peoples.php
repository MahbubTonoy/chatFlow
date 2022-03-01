<?php
session_start();
?>
<?php require "logouter.php"; ?>
<!doctype html>
<html lang = "en" >
  <head>
  <?php 
        if(!isset($_REQUEST['profileid'])){
          header("location: profile.php");
        }
      ?>
    <meta charset = "utf-8" />
    <meta name = "viewport" content = "width = device-width; initial-scale = 1.0" />
    <title></title>
    <?php require "bootstrap.php"; ?>
    <?php require "connectscript.php"; ?>
    <?php require "header.php"; ?>
  <head>
  <body>
    <div class = "container">
      <?php require "navbar.php"; ?>
      
    </div>
  </body>
</html>