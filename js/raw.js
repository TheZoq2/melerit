var mainDiv;

var loginForm;

var courses = Array();
var exercises;
var parameters;

function Course(ID, name, startDate, endDate)
{
	this.ID = ID;
	this.name = name;
	this.startDate = startDate;
	this.endDate = endDate;
}

function setupRaw()
{
	mainDiv = document.getElementById("wrapper");

	showLoginScreen();
}

function showLoginScreen()
{
	//clearing the form
	mainDiv.innerHTML = "";

	loginForm = document.createElement("form");
	loginForm.method = "POST";

	actionField = createInput("action", "hidden");
	actionField.value = "Login";
	loginForm.appendChild(actionField);

	loginForm.appendChild(createLabel("Username: "));
	loginForm.appendChild(createInput("username", "text"));

	loginForm.appendChild(createLabel("Password: "));
	loginForm.appendChild(createInput("password", "password"));

	mainDiv.appendChild(loginForm);
	mainDiv.appendChild(createButton("Login", sendLogin));
}

function sendLogin()
{
	sendFormJsByForm(loginForm, "", onLogin);
}
function onLogin(response)
{
	console.log(response);

	//Requesting the exercises
	createRequest("requests.php", "action=getRawCourses", handleRawCourses)
}

function handleRawCourses(response)
{
	//Getting the courses from the string
	courses = decodeString(response, ";", ",", "=");

	showCourses();
}
function showCourses()
{
	mainDiv.innerHTML = "<h3>Select a course</h3>";

	courseForm = document.createElement("form");

	var courseList = courses.getDataArray();
	//Creating course buttons
	for(var i = 0; i < courseList.length; i++)
	{
		var courseName = courseList[i].getVariableByName("name");
		var courseID = courseList[i].getVariableByName("ID");

		var input = createInputWithLabel(courseName, "i_" + i, "radio", "courseID", courseID);

		courseForm.appendChild(input);
	}

	courseForm.appendChild(createInput("action", "hidden", "getExercisesInCourse"));
	courseForm.appendChild(createInput("", "submit", "Show exercises"));

	mainDiv.appendChild(courseForm);
	
	courseForm.onsubmit = sendGetExercises;
}

function sendGetExercises()
{
	//Sending the data with js
	sendFormJsByForm(this, "", handleRawExercises);

	return false; //Prevent the form from sending the data aswell
}
function handleRawExercises(response)
{
	exercises = decodeString(response, ";", ",", "=");

	sendGetParamData();
	showExercises();
}

function showExercises()
{
	mainDiv.innerHTML = "<h3>Select an exercise</h3>";

	exerciseForm = document.createElement("form");

	if(exercises) //If the exercises hasn't been fetched yet
	{
		exerciseList = exercises.getDataArray();

		for(var i = 0; i < exerciseList.length; i++)
		{
			var exerciseName = exerciseList[i].getVariableByName("name");
			var exerciseID = exerciseList[i].getVariableByName("ID");

			var input = createInputWithLabel(exerciseName, "i_" + i, "radio", "exerciseID", exerciseID);

			exerciseForm.appendChild(input);
		}

		//exerciseForm.appendChild(createInput("action"))
	}
	else
	{
		console.log("Exercises have not been fetched");
	}

	if(parameters)
	{
		//Adding the parameters to the form
		var paramList = parameters.getDataArray();

		exerciseForm.appendChild(createElement("h3", "Param values"));

		for(var i = 0; i < paramList.length; i++)
		{
			var paramName = paramList[i].getVariableByName("name");
			var dbName = paramList[i].getVariableByName("dbName");

			exerciseForm.appendChild(createLabel(paramName));
			exerciseForm.appendChild(createInput(dbName, "text", "0"));
		}
	}
	else
	{
		console.log("no parameters");
	}

	exerciseForm.appendChild(createInput("submit", "submit", "Send result"));

	mainDiv.appendChild(exerciseForm);

	exerciseForm.onsubmit = sendExercise;
}

function sendGetParamData()
{
	createRequest("requests.php", "action=getParams", handleParamData);
}
function handleParamData(response)
{
	//Saving the param data
	parameters = decodeString(response, ";", ",", "=");

	showExercises(); //Rerun the show exercises function
}

function sendExercise()
{
	//Send the result via JS as usual
	sendFormJsByForm(this, "", handleExerciseResponse);

	return false; //Prevent HTML from sending the form
}
function handleExerciseResponse(response)
{
	console.log(response);
}