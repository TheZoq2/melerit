var courseDropdown;
var exerciseDropdown;

function setupResults()
{
	courseDropdown = document.getElementById("courseDropdown");
	exerciseDropdown = document.getElementById("exerciseDropdown");

	getExercises();//Get the exercises for the first value

	courseDropdown.onchange = getExercises;
}
function getExercises()
{
	if(courseDropdown.length > 0)
	{
		var selectedIndex = courseDropdown.selectedIndex;
		var courseID = courseDropdown.options[selectedIndex].value;

		//Creating a request to get the exercises in the course
		createRequest("requests.php", "action=getExerciseDropdown&courseID=" + courseID, handleExercises);
	}
}
function handleExercises(response)
{
	exerciseDropdown.innerHTML = response;

	//Getting the results
	updateResults();
	exerciseDropdown.onchange = updateResults;
}
function updateResults()
{
	if(exerciseDropdown.options.length > 0)
	{
		var selectedIndex = exerciseDropdown.selectedIndex;
		var exerciseID = exerciseDropdown.options[selectedIndex].value;

		getResults(exerciseID);
	}
	else
	{
		emptyResultTable();
	}
}

function getResults(exerciseID)
{
	console.log(exerciseID);
	createRequest("requests.php", "action=getUserScore&exerciseID=" + exerciseID, function(result){
		addResultsToTable("resultTable", result);

		console.log(result);
	});
}

function addResultsToTable(tableID, result)
{
	var table = document.getElementById(tableID);

	table.innerHTML = result;
}
function emptyResultTable(tableID)
{
	addResultsToTable("resultTable", "");
}