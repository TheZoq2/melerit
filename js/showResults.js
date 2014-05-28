function getResults(exerciseID)
{
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