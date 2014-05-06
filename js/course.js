function setupCourses()
{
	var dateField = document.getElementById('coruseStartDate');
	if(dateField != null)
	{
		datePicker = new datepickr('coruseStartDate');

		datePicker2 = new datepickr('courseEndDate');
	}

	courseSubmitButton = document.getElementById("b_submitCourse"); 
	
	if(courseSubmitButton != null)
	{
		courseSubmitButton.onclick = sendNewCourseRequest;
	}

	reloadCourses();
}

function reloadCourses()
{
	//send a request for the course data
	var request = "action=getCourses"
	createRequest("requests.php", request, showCourses)
}
function showCourses(response)
{
	console.log(response);

	var courseArea = document.getElementById("courseArea");

	courseArea.innerHTML = response;
}

function sendNewCourseRequest()
{
	//Getting the values
	var nameField = document.getElementById('courseName');
	var startDateField = document.getElementById('coruseStartDate');
	var endDateField = document.getElementById('courseEndDate');

	var name = nameField.value;
	var startDate = startDateField.value;
	var endDate = endDateField.value;

	var request = "action=addCourse&name=" + name + "&startDate=" + startDate + "&endDate=" + endDate;

	createRequest("requests.php", request, handleAddCourseRequest);
}

function handleAddCourseRequest(response)
{
	console.log(response);
	reloadCourses();
}