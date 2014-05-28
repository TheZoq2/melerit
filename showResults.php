<?php
	require_once("connect.php");

	session_start();

	if(isset($_SESSION["username"]) == false)
	{
		header("location:login.php");
	}

	//Dropdown menu for showing courses 

	$dbo = getDbh();

	//Getting all the courses that the user is part of
	$courseRequest = 
		"SELECT course.ID, course.name, users.ID as userID
		FROM coursemember, users, course
		WHERE users.ID=:userID AND course.ID=coursemember.courseID AND users.ID=coursemember.userID";

	$courseStmt = $dbo->getDbh();

	$courseStmt->bindParam(":userID", $_SESSION["userID"]);
	$courseStmt->execute();
	$courseResult = $courseStmt->fetchAll();

	//Creating the drodown table

	$dropdown = "<select>";
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


		<script>
			getResults(12);

			setupGraph("c_graph1");
		</script>
	</div>
</body>
</html>