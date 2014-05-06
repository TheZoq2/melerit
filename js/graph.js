var canvas;

var ctx;

function setupGraph(canvasID)
{
	canvas = document.getElementById(canvasID);
	ctx = canvas.getContext("2d");

	cls();
}

function cls()
{
	ctx.fillStyle="#000000";
	ctx.clearRect(0, 0, canvas.width, canvas.height);
	ctx.fillRect(0, 0, canvas.width, canvas.height);
}