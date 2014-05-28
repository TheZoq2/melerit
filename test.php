<?php
	echo("hello world");

	sqlRequest = "SELECT param.minVal, param.maxVal, param.minValOk, param.maxValOk 
		FROM exercise, param
		WHERE (exercise.param1=param.ID) AND (exercise.ID=12)";
?>