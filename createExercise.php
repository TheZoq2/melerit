<?php
	require_once("data.php");
?>

<html>
<head>
	<meta charset="utf-8">
</head>
<body>

	<form>
		<?php
			//Generating input fields for each parameter
			for($i = 0; $i < count($parameters); $i++)
			{
				echo("<div class='parameterForm'>
						<h3> " . $parameters[$i] . "</h3>
						<label>Minimum value:</label>
						<input type='text' name='" . $parameters[$i]->getName() ."_minVal'></input>
						
						<label>Maximum value:</label>
						<input type='text' name='" . $parameters[$i]->getName() ."_maxVal'></input>

						<label>Minimm OK value:</label>
						<input type='text' name='" . $parameters[$i]->getName() ."_minValOk'></input>

						<label>Maximum OK value:</label>
						<input type='text' name='" . $parameters[$i]->getName() ."_maxVal'></input>
					</div>");
			}
		?>
		<input type="hidden" value="addExercise" name="action">
		<input type="submit" value="Add exercise">
	</form>
<body>
</html>