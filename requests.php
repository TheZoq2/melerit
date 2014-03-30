<?php
	require_once("connect.php");
	require_once("5.5PasswordFix/fix.php");

	require_once("data.php");
	session_start();

	class ResultPrototype
	{
		__construct($name, $value, $passed);

		private $name;
		private $value;
		private $passed;
	}

	$errorMsg = "";

	if(isset($_POST["action"]))
	{

		if($_POST["action"] == "Register")
		{
			//Checking if the username is in use
			$sqlRequest = "SELECT * FROM `users` WHERE `name`=:username";

			$dbo = getDbh();
			$stmt = $dbo->prepare($sqlRequest);
			$stmt->bindParam(":username", $_SESSION["username"]);
			$stmt->execute();

			$result = $stmt->fetchAll();

			if(count($result) == 0)
			{
				$hashedPass = password_hash($_POST["password"]);

				$sqlRequest = "INSERT INTO `users`(`name`, `password`) VALUES (:name, :password)";

				//Add the user to the database
				$dbo = getDbh();
				$stmt = $dbo->prepare($sqlRequest);
				$stmt->bindParam(":name", $_POST["username"]);
				$stmt->bindParam(":password", $hashedPass);

				$stmt->execute();
			}
			else
			{
				$errorMsg .= "<p>Username already exists</p>";
			}
		}
		if($_POST["action"] == "Login")
		{
			//Fetching users from the database
			$sqlRequest = "SELECT * FROM `users` WHERE `name`=:username";

			$dbo = getDbh();
			$stmt = $dbo->prepare($sqlRequest);
			$stmt->bindParam(":username", $_POST["username"]);
			$stmt->execute();
			$result = $stmt->fetchAll();

			if(count($result) != 0) //If the username exists
			{
				if(password_verify($_POST["password"], $result[0]["password"]))
				{
					$_SESSION["username"] = $_POST["username"];
					$_SESSION["userID"] = $result[0]["ID"];

					echo("logged in sucessfully");

					exit();
				}
				else
				{
					$errorMsg .= "ERROR:Uername or password is wrong";
				}
			}
			else
			{
				$errorMsg .= "ERROR:Username or password is wrong";
			}
		}
		if($_POST["action"] == "addScore") //Adding a score
		{
			if(isset($_SESSION["userID"]))
			{
				$exerciseID = 1;
				$userID = $_SESSION["userID"];

				$dbo = getDbh();

				//Getting the parameters
				$sqlRequest = "INSERT INTO `result`(`date`, `userID`, `exerciseID`, `param1`, `param2`, `param3`, `param4`)
					 VALUES (CURRENT_TIMESTAMP, :userID, :exerciseID, :param1, :param2, :param3, :param4)";

				$stmt = $dbo->prepare($sqlRequest);
				$stmt->bindParam(":userID", $userID);
				$stmt->bindParam(":exerciseID", $exerciseID);
				$stmt->bindParam(":param1", $_POST["param1"]);
				$stmt->bindParam(":param2", $_POST["param2"]);
				$stmt->bindParam(":param3", $_POST["param3"]);
				$stmt->bindParam(":param4", $_POST["param4"]);

				$stmt->execute();

				echo("Adding score");
			}
			else
			{
				$errorMsg .="ERROR:Failed to add score, user is not logged in";
			}
		}
		if($_POST["action"] = "getUserScore")
		{
			$resultArray = array(); //The array that will be returned when everything is doen
			$sqlRequest = "SELECT * FROM `result`
				 WHERE userID=:userID";

			$userID = $_SESSION["userID"];

			//Requesting the results from the database
			$dbo = getDBH();
			$stmt = $dbo->prepare($sqlRequest);
			$stmt->bindParam(":userID", $userID);

			$stmt->execute();
			$results = $stmt->fetchAll();

			foreach($results as $result)
			{
				//fetching the exercise that the results were sent fo
				$sqlRequest = "SELECT * FROM `parameter` WHERE `exerciseID`=:exID";

				$stmt = $dbo->prepare($sqlRequest);
				$stmt->bindParam(":exID", $result["exerciseID"]);

				$stmt->execute();

				$exercise = $stmt->fetchAll();

				//Looping thru all the parameters
				for($i = 0; $i < count($parameters); $i++)
				{
					//Comparing the value to the coal
					for($n = 0; $n < count($exercise); $n++)
					{
						
					}
				}
			}
		}
		if($_POST["action"] == "ping")
		{
			echo "pong";

			exit();
		}
	}

	echo $errorMsg;
?>