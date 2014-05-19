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

			//header("location:index.php");
			exit();
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

			//header("location:index.php");
			exit();
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
				$errorMsg .= "ERROR:Failed to add score, user is not logged in";
			}

			exit();
		}
		if($_POST["action"] == "getUserScore")
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

			exit();
		}
		if($_POST["action"] == "ping")
		{
			echo "pong";

			exit();
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
	}

	echo $errorMsg;

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
				"<td>" . $endDate . "</td>" .
				"<td><a href='manage.php?id=" . $course["courseID"] . "&action=editCourse'>add</a>"; 
			"</tr>";
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
					$minVal = $_POST[$paramData->getDbName() . '_min'];
					$maxVal = $_POST[$paramData->getDbName() . '_max'];
					$minValOk = $_POST[$paramData->getDbName() . '_maxOk'];
					$maxValOk = $_POST[$paramData->getDbName() . '_minOk'];

					//Creating a param in the database
					$sqlRequest = 
						"INSERT INTO `param`(`minVal`, `maxVal`, `minValOk`, `maxValOk`) 
						VALUES (':min', ':max', ':minOk', ':maxOk')";

					$stmt = $dbo->prepare($sqlRequest);;
					$stmt->bindParam(":min", $minVal);
					$stmt->bindParam(":max", $maxVal);
					$stmt->bindParam(":minOk", $minValOk);
					$stmt->bindParam(":minOk", $maxValOk);

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

				echo ($exerciseRequest);

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

		print_r($_SESSION["userID"]);
		print_r($_SESSION);

		echo($responseString);
	}
?>