var mainDiv;

var loginForm;

var courses = Array();

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
	console.log(response);
}