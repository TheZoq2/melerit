<?php
	require_once("connect.php");

	session_start();

	if(isset($_SESSION["username"]) == false)
	{
		header("location:login.php");
	}

	/*unset($_SESSION["username"]);
	unset($_SESSION["userID"]);*/

	$courseArea = "";

	//Displaying all the courses that the user is part of
	$courseArea .= 
	"<h1>Courses</h1>" .
	"<h3>Current courses</h3>" .
	"<table id='courseArea'>" .
	"</table>";
	if($_SESSION["userRole"] == 1) //If the user is an admin
	{
		$courseArea .=
		"<h3>Add new course</h3>" .
		"<form method='POST' action='requests.php'>" .
			"<label>Course name</label><input type='text' name='courseName' id='courseName'>" . 

			"<label>Start time</label><input name='startDate' id='coruseStartDate'>" .
			"<label>End time</label><input type='name' name='endDate' id='courseEndDate'>" .
			
			"<input type='hidden' name='action' value='addCourse'>" .

			"<input type='button' id='b_submitCourse'>" .
		"</form>";
	}
?>

<html>
<head>
	<meta charset="UTF-8">

	<script src="js/requests.js"></script>
	<script src="js/course.js"></script>

	<script src="js/datepickr/datepickr.js"></script>
</head>
<body>
	<h1>Submit result</h1>

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

	<form method="POST" action="requests.php"> 
		<input type="hidden" name="action" value="logout">
		<input type="submit" value="Log out">
	</form>

	<?php
		echo($courseArea);
	?>
	<script>
		setupCourses();
	</script>
</body>
</html>