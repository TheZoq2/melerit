<?php
	require_once("connect.php");
	$dbo = getDbh();

	//<todo> Chec user

	$content = "";

	if(isset($_GET["action"]))
	{
		if($_GET["action"] == "editCourse")
		{
			//Fetching data about the course
			$sqlRequest = "SELECT * FROM `course` WHERE `ID`=:id";

			$stmt = $dbo->prepare($sqlRequest);
			$stmt->bindParam(":id", $_GET["id"]);
			$stmt->execute();

			$stmt->execute();
			$course = $stmt->fetch();

			$startDate = gmdate("Y-m-d", $course["startDate"]);
			$endDate = gmdate("Y-m-d", $course["endDate"]);
			$content .= 
			"<form>" . 
				"<input type='text' name='name' value='" . $course["name"] . "'>" .
				"<input type='text' name='startDate' value='" . $startDate . "'>" .
				"<input type='text' name='endDate' value='" . $endDate . "'>" .
				"<input type='hidden' name='courseID' value='" . $course["ID"] . "' id='courseID'>".
			"</form>";

			//Ading members

			//Fetching all the users that are not part of the course in the database
			//PHP is terrible and doesn't when using insert
			$sqlRequest = 
				"CREATE TEMPORARY TABLE test(
				    ID INT);

				INSERT INTO test SELECT DISTINCT `users`.ID 
								FROM `users` 
								LEFT OUTER JOIN `coursemember` ON `coursemember`.userID=`users`.ID
								WHERE `coursemember`.`courseID`=:courseID;";

			$stmt = $dbo->prepare($sqlRequest);
			$stmt->bindParam(":courseID", $_GET["id"]);
			$stmt->execute();

			$sqlRequest = 
				"SELECT users.ID, users.name, users.role
				FROM users
				LEFT OUTER JOIN test ON test.ID=users.ID
				WHERE test.ID IS NULL";

			/*full rquest
			CREATE TEMPORARY TABLE test(
				    ID INT);

				INSERT INTO test SELECT DISTINCT `users`.ID 
								FROM `users` 
								LEFT OUTER JOIN `coursemember` ON `coursemember`.userID=`users`.ID
								WHERE `coursemember`.`courseID`=17;
			SELECT * 
				FROM users
				LEFT OUTER JOIN test ON test.ID=users.ID
				WHERE test.ID IS NULL

			*/
			$stmt = $dbo->prepare($sqlRequest);
			//$stmt->bindParam(":courseID", $_GET["id"]);
			$stmt->execute();

			$usersNotInCourse = $stmt->fetchAll();

			$content .= "<h3>Add members</h3>".

			"<table id='addMemberTable'>";
			//Creating a table with all the users
			foreach($usersNotInCourse as $user)
			{
				$content .= 
				"<tr>".
					"<td>" .
						"<input type='checkbox' name='userID' value='" . $user["ID"] . "'>" .
					"</td>" .
					"<td>" .
						$user["name"] . 
					"</td>" .
				"</tr>";
			}
			$content .=
			"</table>" .
			"<button id='submitMembers'>Add members</button>";
 		}
	}
	else
	{
		$content += "<p>Error: No action specified</p>";
	}
?>

<html>
<head>
	<meta charset="utf-8">

	<script src="js/manage.js"></script>
	<script src="js/requests.js"></script>
</head>
<body>
	<?php
		echo($content);
	?>

	<script>
		setupManage();
	</script>
</body>
</html>