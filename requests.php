<?php
	require_once("connect.php");
	//require_once("5.5PasswordFix/fix.php");

	require_once("data.php");
	session_start();

	class ParamPrototype
	{
		function __construct($name, $value, $passed)
		{
			$this->name = $name;
			$this->value = $value;
			$this->passed = $passed;
		}

		public function getValue()
		{
			return $this->value;
		}
		public function getPassed()
		{
			return $this->passed;
		}
		private $name;
		private $value;
		private $passed;
	}
	class ResultPrototype
	{
		function __construct()
		{
			$params = array();
		}

		function addParam($param)
		{
			$this->params[] = $param;
		}

		function getTable()
		{
			global $htmlData;

			$result = "<tr>";
			foreach($this->params as $param)
			{
				$class = $htmlData->getFailedClass();
				if($param->getPassed() == 1)
				{
					$class = $htmlData->getPassedClass();
				}
				if($param->getPassed() == 2)
				{
					$class = $htmlData->getOkClass();
				}

				$result .= 
				"<td class='" . $class . "'>" . 
				$param->getValue() .
				"</td>";

			}
			$result .= "</tr>";

			return $result;
		}
		private $params;
	}

	$errorMsg = "";

	if(isset($_POST["action"]))
	{

		if($_POST["action"] == "Register")
		{
			handleRegister();
		}
		if($_POST["action"] == "Login")
		{
			handleLogin();
		}
		if($_POST["action"] == "addScore") //Adding a score
		{
			handleAddScore();
		}
		if($_POST["action"] == "getUserScore")
		{
			handleGetUserScore();
		}
		if($_POST["action"] == "ping")
		{
			echo "pong";
		}
		if($_POST["action"] == "logout")
		{
			unset($_SESSION["username"]);
			unset($_SESSION["userID"]);
			unset($_SESSION["userRole"]);

			header("location:index.php");
		}
		if($_POST["action"] == "addCourse")
		{
			handleAddCourse();
		}
		if($_POST["action"] == "getCourses")
		{
			handleGetCourse();
		}
		if($_POST["action"] == "addUsers")
		{
			handleAddMembers();
		}
		if($_POST["action"] == "addNewExercise")
		{
			handleAddNewExercise();
		} 

		if($_POST["action"] == "getRawCourses")
		{
			handleGetRawCourses();
		}
		if($_POST["action"] == "getExercisesInCourse")
		{
			handleGetExercisesInCoruse();
		}
		if($_POST["action"] == "getParams")
		{
			handleParamRequest();
		}
		if($_POST["action"] == "submitResult")
		{
			handleResultSubmit();
		}
		if($_POST["action"] == "getExerciseDropdown")
		{
			hanadleExerciseDropdown();
		}
	}

	echo $errorMsg;

	function handleRegister()
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
			$hashedPass = password_hash($_POST["password"], PASSWORD_DEFAULT);

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

	function handleLogin()
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
				$_SESSION["userRole"] = $result[0]["role"];

				echo("logged in sucessfully");

				//print_r($_SESSION);

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

	function handleAddScore()
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
			$errorMsg .= "ERROR:Failed to add score, user is not logged in";
		}
	}

	function handleGetUserScore()
	{
		/*
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

		$resultDisp = array();
		foreach($results as $result)
		{
			//Selecting the exercise
			
			$sqlRequest = "SELECT * FROM `exercise` WHERE `ID`=:exID";

			$stmt = $dbo->prepare($sqlRequest);
			$stmt->bindParam(":exID", $result["exerciseID"]);
			$stmt->execute();
			$exercise = $stmt->fetch();

			$resultProt = new ResultPrototype();

			//Looping thru all the parameters
			for($i = 0; $i < count($parameters); $i++)
			{
				//Getting the para
				$sqlRequest = "SELECT * FROM `parameter` WHERE `ID`=:param";
				$paramID = $exercise[$parameters[$i]->getDbName()];
				$stmt = $dbo->prepare($sqlRequest);
				$stmt->bindParam(":param", $paramID);
				$stmt->execute();

				$param = $stmt->fetch();

				//Comparing the result to the parameter
				$passed = 0;
				if($result[$parameters[$i]->getDbName()] > $param["minVal"] && $result[$parameters[$i]->getDbName()] < $param["maxVal"])
				{
					$passed = 1;
				}
				elseif($result[$parameters[$i]->getDbName()] > $param["minValOK"] && $result[$parameters[$i]->getDbName()] < $param["maxValOK"])
				{
					$passed = 2;
				}

				$paramProt = new ParamPrototype($parameters[$i]->getName(), $result[$parameters[$i]->getDbName()], $passed);

				$resultProt->addParam($paramProt);
			}

			$resultDisp[] = $resultProt;
		}

		for($i = 0; $i < count($resultDisp); $i++)
		{
			echo $resultDisp[$i]->getTable();
		}
		*/
		global $parameters; //Defined in data.php
		global $htmlData;

		$userID = $_SESSION["userID"];
		$exerciseID = $_POST["exerciseID"];

		$dbo = getDbh();

		//Selecting all the results that the user has submitted for the exercise that the user
		$resultRequest = 
			"SELECT result.param1, result.param2, result.param3, result.param4
			FROM result, users 
			WHERE (users.ID=:userID) AND (result.exerciseID=:exerciseID)";

		$resultStmt = $dbo->prepare($resultRequest);

		$resultStmt->bindParam(":userID", $userID);
		$resultStmt->bindParam(":exerciseID", $exerciseID);

		$resultStmt->execute();
		$results = $resultStmt->fetchAll();

		$paramList = array();

		//Fetching all the parameters in the exercise
		foreach($parameters as $param)
		{
			$paramRequest = 
				"SELECT param.minVal, param.maxVal, param.minValOk, param.maxValOk 
				FROM `exercise`, param
				WHERE (exercise." . $param->getDbName() . "=param.ID) AND (exercise.ID=:exerciseID)";

			$paramStmt = $dbo->prepare($paramRequest);

			$paramStmt->bindParam(":exerciseID", $exerciseID);

			$paramStmt->execute();

			$paramList[$param->getDbName()] = $paramStmt->fetch(); 
		}

		$resultString = "";

		//Adding a row with all the parameters
		$resultString .= "<tr>";

		foreach($parameters as $param)
		{
			$resultString .= "<td>" . $param->getName() . "</td>";
		}

		$resultString .= "</tr>";

		//Going through all the results
		foreach($results as $result)
		{
			$resultString .= "<tr>";

			foreach($parameters as $param)
			{
				$passed = false;
				$ok = false;

				$resultValue = $result[$param->getDbName()];

				//Checking if the result is passed
				if($resultValue >= $paramList[$param->getDbName()]["minVal"] &&
					$resultValue <= $paramList[$param->getDbName()]["maxVal"])
				{
					$passed = true;
				}
				//Checking if the value is "ok"
				elseif($resultValue >= $paramList[$param->getDbName()]["minValOk"] &&
					$resultValue <= $paramList[$param->getDbName()]["maxValOk"])
				{
					$ok = true;
				}

				//adding the cell
				$resultString .= "<td class='";

				if($passed == true)
				{
					$resultString .= $htmlData->getPassedClass();
				}
				elseif($ok == true)
				{
					$resultString .= $htmlData->getOkClass();


				}
				else
				{
					$resultString .= $htmlData->getFailedClass();
				}

				$resultString .= "'>" . $result[$param->getDbName()] . "</td>";
			}

			$resultString .= "</tr>";
		}

		echo($resultString);
	}

	function handleAddCourse()
	{
		$dbo = getDbh();
		//Checking if the times are goood
		$startTime = strtotime($_POST["startDate"]);
		$endTime = strtotime($_POST["endDate"]);

		$paramsValid = true;
		//Making sure the course doesn't start in the past
		if(!is_numeric($startTime))
		{
			$paramsValid = false;
			echo("Error: Starttime is not a valid time");
		}
		if(!is_numeric($endTime))
		{
			$paramsValid = false;
			echo("Error: Endtime is not a valid time");
		}

		if($paramsValid == true)
		{
			//Filtering input
			$name = htmlspecialchars($_POST["name"]);

			$sqlRequest =
			"INSERT INTO `course`(`name`, `startDate`, `endDate`)" . 
				" VALUES (:name, :startDate, :endDate);";

			$stmt = $dbo->prepare($sqlRequest);
			$stmt->bindParam(":name", $name);
			$stmt->bindParam(":startDate", $startTime);
			$stmt->bindParam(":endDate", $endTime);

			$stmt->execute();

			//Fetching the last ID created
			$sqlRequest = "SELECT MAX(`ID`) AS createdID FROM `course`";
			$stmt = $dbo->prepare($sqlRequest);
			$stmt->execute();
			$result = $stmt->fetch();

			//Adding the the user to the coure
			addUserToCourse($_SESSION["userID"], $result["createdID"]);

			echo("Course added");
		}
	}

	function addUserToCourse($userID, $courseID)
	{
		$sqlRequest = "INSERT INTO `coursemember`(`userID`, `courseID`) VALUES (:userID, :courseID)";

		$dbo = getDbh();

		$stmt = $dbo->prepare($sqlRequest);

		$stmt->bindParam(":userID", $userID);
		$stmt->bindParam(":courseID", $courseID);

		$stmt->execute();
	}

	function handleGetCourse()
	{
		if(isset($_SESSION["userID"]) == false)
		{
			echo("User is not logged in");
			return;
		}
		//SQL to fetch all the courses that the user is part of
		$sqlRequest = "SELECT *
			FROM `course` , `coursemember`
			WHERE `coursemember`.userID=:userID
			AND `coursemember`.courseID = `course`.ID";

		$dbo = getDbh();
		$stmt = $dbo->prepare($sqlRequest);
		$stmt->bindParam(":userID", $_SESSION["userID"]);
		$stmt->execute();

		$result = $stmt->fetchAll();

		//Creating a table for the result
		$table = 
		"<tr>" .
			"<td>Name</td>" .
			"<td>Start date</td>" .
			"<td>End date</td>";

		//if the user is an admin
		if($_SESSION["userRole"] == 1)
		{
			$table .= 
			"<td>Add members</td>";
		}

		foreach($result as $course)
		{
			//Converting the dates to a readable format
			$startDate = gmdate("Y-m-d", $course["startDate"]);
			$endDate = gmdate("Y-m-d", $course["endDate"]);

			$table .= 
			"<tr>" .
				"<td>" . $course["name"] . "</td>" .
				"<td>" . $startDate . "</td>" .
				"<td>" . $endDate . "</td>";

			if($_SESSION["userRole"] == 1) //If the user is an admin
			{
				//Add manage button
				$table .= "<td><a href='manage.php?id=" . $course["courseID"] . "&action=editCourse'>add</a>"; 
			}
			else
			{

			}
			$table .= "</tr>";
		}

		$table .= "</table>";

		echo($table);
	}

	function handleAddMembers()
	{
		//Db connection
		$dbo = getDbh();

		//Splitting the string
		$users = explode(",", $_POST["users"]);

		array_pop($users);

		foreach($users as $user)
		{
			//Adding the user to the course
			//$sqlRequest = "INSERT INTO `usercourse`(`courseID`, `exerciseID`) VALUES (:course,:user)";
			$sqlRequest = "INSERT INTO `coursemember`(`courseID`, `userID`) VALUES (:course,:user)";

			$stmt = $dbo->prepare($sqlRequest);
			$stmt->bindParam(":course", $_POST["courseID"]);
			$stmt->bindParam(":user", intval($user));
			$stmt->execute();

			echo("added users");
		}
	}
	function handleAddNewExercise()
	{
		global $parameters;
		if($_SESSION["userRole"] == 1)
		{
			//Converting the time to a timestamp
			//Checking if the times are goood
			$startTime = strtotime($_POST["startDate"]);
			$endTime = strtotime($_POST["endDate"]);

			$paramsValid = true;
			//Making sure the course doesn't start in the past
			if(!is_numeric($startTime))
			{
				$paramsValid = false;
				echo("Error: Starttime is not a valid time");
			}
			if(!is_numeric($endTime))
			{
				$paramsValid = false;
				echo("Error: Endtime is not a valid time");
			}

			if($paramsValid == true)
			{
				$dbo = getDbh();

				//array containing all the newly created parameters
				$createdParams = array();			

				//Getting the parameter data
				foreach($parameters as $paramData)
				{
					$minVal = 0;
					$maxVal = 0;
					$minValOk = 0;
					$maxValOk = 0;

					//Getting the values from the post request
					$minVal = (float) $_POST[$paramData->getDbName() . '_min'];
					$maxVal = (float) $_POST[$paramData->getDbName() . '_max'];
					$minValOk = (float) $_POST[$paramData->getDbName() . '_minOk'];
					$maxValOk = (float) $_POST[$paramData->getDbName() . '_maxOk'];

					//Creating a param in the database
					$sqlRequest = 
						"INSERT INTO `param`(`minVal`, `maxVal`, `minValOk`, `maxValOk`) 
						VALUES (:min, :max, :minOk, :maxOk)";

					$stmt = $dbo->prepare($sqlRequest);;
					$stmt->bindParam(":min", $minVal);
					$stmt->bindParam(":max", $maxVal);
					$stmt->bindParam(":minOk", $minValOk);
					$stmt->bindParam(":maxOk", $maxValOk);

					$stmt->execute();

					//Selecting the newly created ID
					$sqlRequest = 
						"SELECT MAX(`ID`) as maxID
						FROM `param`
						WHERE 1";
					$stmt = $dbo->prepare($sqlRequest);
					$stmt->execute();

					$createdParams[$paramData->getDbName()] = $stmt->fetch()["maxID"];
				}

				//Creating the exercise using the values
				$exerciseRequest = 
					"INSERT INTO `exercise`(`Name`, `startDate`, `endDate`";

				//Adding the parameters
				foreach($parameters as $paramData)
				{
					$exerciseRequest .= ", " . $paramData->getDbName();
				} 
				$exerciseRequest .= ")" .
					"VALUES (:name, :startDate, :endDate";
				
				//Adding SQL params
				foreach($parameters as $paramData)
				{
					$exerciseRequest .= ", :" . $paramData->getDbName();
				}
				$exerciseRequest .= ");";

				//echo ($exerciseRequest);

				$stmt = $dbo->prepare($exerciseRequest);
				//Binding all the parameters
				$stmt->bindParam(":name", $_POST["name"]);
				$stmt->bindParam(":startDate", $startTime);
				$stmt->bindParam(":endDate", $endTime);

				foreach($parameters as $paramData)
				{
					$stmt->bindParam(":" . $paramData->getDbName(), $createdParams[$paramData->getDbName()]);
				}

				$stmt->execute();

				//Selecting the ID of the created exercise and linking that to the course
				$sqlRequest = "SELECT MAX(ID) AS maxID
					FROM `exercise`
					WHERE 1";

				$stmt = $dbo->prepare($sqlRequest);

				$stmt->execute();
				$result = $stmt->fetch();

				//Creating a link
				$sqlRequest = "INSERT INTO `exercisecourse`(`courseID`, `exerciseID`) VALUES (:courseID,:exerciseID)";
				$stmt = $dbo->prepare($sqlRequest);
				$stmt->bindParam(":courseID", $_POST["courseID"]);
				$stmt->bindparam(":exerciseID", $result["maxID"]);
				$stmt->execute();
			}
		}
		else
		{
			echo("<p class='error'>You ned to be an admin to do that</p>");
		}
	}
	function handleGetRawCourses()
	{
		//Selecting all the courses that the user is part of from the database
		$sqlRequest = 
			"SELECT course.ID, course.name, course.startDate, course.endDate 
			FROM `course`, coursemember 
			WHERE coursemember.courseID = course.ID AND coursemember.userID=:userID";

		$dbo = getDbh();

		$stmt = $dbo->prepare($sqlRequest);
		$stmt->bindParam(":userID", $_SESSION["userID"]);
		$stmt->execute();

		$courses = $stmt->fetchAll();

		//Creating a response
		$responseString = "";

		$resultArray = array();

		foreach($courses as $course)
		{
			$courseString = "ID=" . $course["ID"];
			$courseString .= ",name=" . $course["name"];
			$courseString .= ",startDate=" . $course["startDate"];
			$courseString .= ",endDate=" . $course["endDate"];

			$resultArray[] = $courseString;
		}

		$responseString = implode(";", $resultArray);

		echo($responseString);
	}
	function handleGetExercisesInCoruse()
	{
		$courseID = $_POST["courseID"];

		//Selecting all the exercises in the course
		
		$sqlRequest = "SELECT exercisecourse.`exerciseID` AS ID, exercise.name, exercise.startDate, exercise.endDate 
			FROM `exercisecourse`, exercise 
			WHERE (courseID=:courseID) AND (exercise.ID = exercisecourse.exerciseID)";

		$dbo = getDbh();

		$stmt = $dbo->prepare($sqlRequest);

		$stmt->bindParam(":courseID", $_POST["courseID"]);

		$stmt->execute();

		$exercises = $stmt->fetchAll();

		//Returning the exercises.
		$resultArray = array();

		foreach($exercises as $exercise)
		{
			$exerciseString = "ID=" . $exercise["ID"];
			$exerciseString .= ",name=" . $exercise["name"];
			$exerciseString .= ",startDate=" . $exercise["startDate"];
			$exerciseString .= ",endDate=" . $exercise["endDate"];
			
			$resultArray[] = $exerciseString;
		}

		$responseString = implode(";", $resultArray);

		echo($responseString);
	}

	function handleParamRequest()
	{
		global $parameters; //Defined in data.php

		//Returning a list of all the parameters
		$resultArray = array();
		foreach($parameters as $param)
		{
			$resultArray[] = "name=" . $param->getName() .
				",dbName=" . $param->getDbName();
		}

		$resultString = implode(";", $resultArray);

		echo($resultString);
	}

	function handleResultSubmit()
	{
		global $parameters; //Defined in data.php
		if(isset($_SESSION["userID"]))
		{
			$sqlRequest = "INSERT INTO `result`(`exerciseID`, `date`, userID";

			//Adding all the parameters to the request
			foreach($parameters as $param)
			{
				$sqlRequest .= ", " . $param->getDbName();
			}

			$sqlRequest .= ")VALUES (:exerciseID, CURDATE(), :userID";

			foreach($parameters as $param)
			{
				$sqlRequest .= ", :" . $param->getDbName();
			}

			$sqlRequest .=")"; //finishing the request

			//Connecting to the DB
			$dbo = getDbh();

			$stmt = $dbo->prepare($sqlRequest);

			$stmt->bindParam(":userID", $_SESSION["userID"]);
			$stmt->bindParam(":exerciseID", $_POST["exerciseID"]);

			//Adding the parameters
			foreach($parameters as $param)
			{
				$stmt->bindParam(":" . $param->getDbName(), $_POST[$param->getDbName()]);
			}

			//Execute the request
			$stmt->execute();
		}
		else
		{
			echo("error: User is not logged in");
		}
	}
	function hanadleExerciseDropdown()
	{
		//Connecting to the database
		$dbo = getDbh();

		$sqlRequest = 
			"SELECT exercise.ID, exercise.name
			FROM exercisecourse, exercise
			WHERE (exercisecourse.courseID=:courseID) AND (exercise.ID=exercisecourse.exerciseID)";

		$stmt = $dbo->prepare($sqlRequest);
		$stmt->bindParam(":courseID", $_POST["courseID"]);
		$stmt->execute();

		$exercises = $stmt->fetchAll();

		$resultStr = "";
		//Creating the dropdown content
		foreach($exercises as $exercise)
		{
			$resultStr .= 
				"<option value='" . $exercise["ID"] . "'>" .
					$exercise["name"] .
				"</option>";
		}

		echo($resultStr);
	}
?>