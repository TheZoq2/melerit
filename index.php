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