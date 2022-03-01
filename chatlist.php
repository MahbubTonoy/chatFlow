<?php require "logouter.php"; ?>
<?php require "connectscript.php"; ?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Chat List | ChatFlow</title>
	<?php require "header.php"; ?>
	<?php require "bootstrap.php"; ?>
</head>
<body>
	<div class = "container">
		<?php require "navbar.php"; ?>
		<div class = "msglist" id = 'getchatlistID' >
		<noscript>
			<!---working--->
		</noscript>
		<?php require "getchatlist.php"; ?>
			
		</div>

	</div>
	<style>
	 .anchors:hover{
		text-decoration:none;
	 }
	 .row:hover{
		 background-color:#eee;
		 border-radius: 5px;
	 }
	 .row{
			font-family: Verdana,sans-serif;
	 }
	</style>
	<script>

	function mkfresh(){
		$("#getchatlistID").load("getchatlist.php" , function(responseTxt){
            
    }).show();
	}
	
		setInterval(mkfresh, 2000);
	</script>

<div style = 'margin: 15px auto;' class = 'container get-frnd-div-yellow alert alert-warning'>You Have No Conversation With Your Friends on Chatflow<br/>Find Your Friends And Start Chating<form style = 'margin: 10px;' action = 'search.php' method = 'get'>
<input style = 'margin: 2px 10px 2px 0px;' class = 'form-control' type = 'search' name = 'q' placeholder = 'Search Friends...' />
<input type = 'submit' value = 'Search' class = 'btn btn-primary' />
</form></div>
	<div style = 'margin:auto;' class = 'container get-frnd-div-green alert alert-success'>Get More Friends On ChatFlow<br/>Search Here<form style = 'margin: 10px;' action = 'search.php' method = 'get'>
					<input style = 'margin: 2px 10px 2px 0px;' class = 'form-control' type = 'search' name = 'q' placeholder = 'Search Friends...' />
					<input type = 'submit' value = 'Search' class = 'btn btn-primary' />
				</form></div>
</body>
</html>