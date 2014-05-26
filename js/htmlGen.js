function createInput(name, type, value)
{
	if(!value) //If the value is undefined
	{
		value = ""; 
	}

	var input = document.createElement("input");

	input.type = type;
	input.name = name;
	input.value = value;


	return input;
}
function createLabel(text)
{
	var label = document.createElement("label");

	label.innerHTML = text;

	return label;
}

function createButton(text, onclick)
{
	var button = document.createElement("button");

	button.innerHTML = text;
	button.onclick = onclick;

	return button;
}

function createInputWithLabel(labelText, ID, type, name, value)
{
	var div = document.createElement("div");

	var input = createInput(name, type, value);
	input.setAttribute("id", ID);

	div.appendChild(input);

	var label = createLabel(labelText);
	label.htmlFor = ID;
	div.appendChild(label);
	
	return div;
}