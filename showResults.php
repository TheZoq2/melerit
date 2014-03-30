<?php
	require_once("connect.php");

	session_start();

	if(isset($_SESSION["username"]) == false)
	{
		header("location:login.php");
	}
?>

<html>
<head>
	<meta charset="UTF-8">

	<script src="js/requests.js"></script>
	<script src="js/showResults.js"></script>
</head>
<body>
	<h1>Results</h1>

	<div id="resutDiv">
		<table id="resultTable">

		</table>
	</div>

	<script>
		getResults();
	</script>
</body>
</html>