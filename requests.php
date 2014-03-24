<?php
	require_once("connect.php");
	require_once("5.5PasswordFix/fix.php");
	session_start();

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
					$errorMsg .= "<p>Logged in</php>";

					$_SESSION["username"] = $_POST["username"];
				}
				else
				{
					$errorMsg .= "<p>Uername or password is wrong</p>";
				}
			}
			else
			{
				$errorMsg .= "<p>Username or password is wrong</p>";
			}
		}
	}

	echo $errorMsg;
?>