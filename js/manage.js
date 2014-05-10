function setupManage()
{
	var addMemberButton = document.getElementById("submitMembers");

	addMemberButton.onclick = function()
	{
		//Getting the course ID
		var courseID = document.getElementById("courseID").value;

		//Getting the info from the form
		var inputs = document.getElementById("addMemberTable").getElementsByTagName("input");

		var checkboxes = Array();
		for(var i = 0; i < inputs.length; i++)
		{
			if(inputs[i].type.toLowerCase() == "checkbox")
			{
				checkboxes[checkboxes.length] = inputs[i];
			}
		}

		var postString = "action=addUsers&users=";
		//creating a string from the data
		for(var i = 0; i < checkboxes.length; i++)
		{
			if(checkboxes[i].checked == true)
			{
				postString = postString + checkboxes[i].value + ",";
			}
		}
		postString = postString + "&courseID=" + courseID;

		createRequest("requests.php", postString, manageAddUsers);
	}
}

function manageAddUsers(response)
{
	console.log(response);
}