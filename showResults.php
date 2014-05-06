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
	<script src="js/graph.js"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/html5reset-1.6.1.css">
</head>
<body>
	<div id="wrapper">
		<h1>Results</h1>

		<div id="resultDiv">
			<table id="resultTable">

			</table>
		</div>

		<div id="canvasContainer">
			<canvas id="c_graph1" width="150" height="200"></canvas>
		</div>

		<script>
			getResults();

			setupGraph("c_graph1");
		</script>
	</div>
</body>
</html>