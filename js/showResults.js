function getResults()
{
	createRequest("requests.php", "action=getUserScore", function(result){
		addResultsToTable("resultTable", result);

		console.log(result);
	});
}

function addResultsToTable(tableID, result)
{
	var table = document.getElementById(tableID);

	table.innerHTML = result;
}