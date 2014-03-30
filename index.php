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
</head>
<body>
	<h1>Hello world</h1>

	<form ID="addResultForm" action="requests.php" method="POST">
		<label>Parameter 1</label><input type="text" name="param1">
		<label>Parameter 2</label><input type="text" name="param2">
		<label>Parameter 3</label><input type="text" name="param3">
		<label>Parameter 4</label><input type="text" name="param4">

		<input type="submit">

		<input type="hidden" name="action" value="addScore">
	</form>

	<a href="createExercise.php">Add a new exercise</a>
	<a href="showResults.php">Show previous results</a>

	<script>
		
	</script>
</body>
</html>