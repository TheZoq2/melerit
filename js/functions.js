
function sendFormJs(formID, additionalVars, onFinished)
{
	var form = document.getElementById(formID);

	var request = "";

	for(var i = 0; i < form.childNodes.length; i++)
	{
		if(form.childNodes[i].tagName == "INPUT")
		{
			//Creating a request from the forms
			request = request + form.childNodes[i].name + "=" + form.childNodes[i].value +
				"&";

		}
	}

	request = request + additionalVars;

	//Sending the request
	createRequest("requests.php", request, onFinished);
}

function sendFormJsByForm(form, additionalVars, onFinished)
{
	//Finding all nodes inside the form to allow for inputs inside divs
	var nodes = Array();
	var foundNodes = Array();

	nodes.push(form);

	//Looping thru all the nodes to find more nodes
	while(nodes.length != 0)
	{
		//Going thru all the child dren of the nodes
		for(var i = 0; i < nodes[0].childNodes.length; i++)
		{
			nodes.push(nodes[0].childNodes[i]);
		}

		//Removing the node from the list
		foundNodes.push(nodes[0]);
		nodes.shift();
	}

	var request = "";
	for(var i = 0; i < foundNodes.length; i++)
	{
		if(foundNodes[i].tagName == "INPUT")
		{
			console.log("agwg");
			//Creating a request from the forms
			request = request + foundNodes[i].name + "=" + foundNodes[i].value +
				"&";
		}
	}

	request = request + additionalVars;

	//Sending the request
	createRequest("requests.php", request, onFinished);
}

function DataGroup()
{
	this.dataList = Array();

	this.addData = function(data)
	{
		this.dataList.push(data);
	}
	this.getDataArray = function()
	{
		return this.dataList;
	}
}
function Data()
{
	this.variables = Array();

	this.addVariable = function(variable)
	{
		this.variables.push(variable);
	}
	this.getVariableByName = function(name)
	{
		for(var i = 0; i < this.variables.length; i++)
		{
			if(this.variables[i].name == name)
			{
				return this.variables[i].value;
			}
		}

		console.log("No variable named " + variable);

		return undefined;
	}
}
function Variable()
{
	this.name = "";
	this.value = "";
}

function decodeString(string, separator1, separator2, separator3)
{
	dataGroup = new DataGroup();

	//Spliting the string into data segments
	var segmentStr = string.split(separator1);

	//Loping thru the segments
	for(var i = 0; i < segmentStr.length; i++)
	{
		var data = new Data();

		var dataStr = segmentStr[i].split(separator2);

		for(var n = 0; n < dataStr.length; n++)
		{	
			var variable = new Variable();

			var varStrings = dataStr[n].split("=");
			
			variable.name = varStrings[0];
			variable.value = varStrings[1];

			data.addVariable(variable);
		}

		//Adding the new data to the group
		dataGroup.addData(data);
	}

	return dataGroup;
}