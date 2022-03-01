<?php require "logouter.php"; ?>
<?php require "connectscript.php"; ?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Active Friends | ChatFlow</title>
	<?php require "header.php"; ?>
	<?php require "bootstrap.php"; ?>
</head>
<body>
	<div class = "container">
		<?php require "navbar.php"; ?>
		<div style = "padding:10px 5px 0px 5px; margin-bottom: 5px; border-bottom:1px solid #ddd;" >
			<h4>People Who Active</h4>
		</div>
		<div class = "activelist">
      <?php require "active_checker.php"; ?>
		</div>
	</div>
	<script>
    function active_checker(){
        $(".activelist").load("active_checker.php" , function(responseTxt){
            
        }).show();
    }
    setInterval(active_checker, 1000);
</script>
<div style = 'margin: 15px auto;' class = 'div-alert-blue alert container alert-primary'>Search For More Friends:<form style = 'margin: 10px;' action = 'search.php' method = 'get'>
					<input style = 'margin: 2px 10px 2px 0px;' class = 'form-control' type = 'search' name = 'q' placeholder = 'Search Friends...' />
					<input type = 'submit' value = 'Search' class = 'btn btn-primary' />
				</form></div>
<div style = 'margin:15px auto;' class = 'div-alert-yellow alert container alert-warning'>None of Your Friends Are Online<br/>Search For More Friends:<form style = 'margin: 10px;' action = 'search.php' method = 'get'>
					<input style = 'margin: 2px 10px 2px 0px;' class = 'form-control' type = 'search' name = 'q' placeholder = 'Search Friends...' />
					<input type = 'submit' value = 'Search' class = 'btn btn-primary' />
				</form></div>
</body>
</html>