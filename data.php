<?php
	class Parameter
	{
		__construct($name, $dbName)
		{
			$this->name = $name;
			$this->dbName = $dbName
		}
		public getName()
		{
			return $this->name;
		}
		public getDbName()
		{
			return $this->dbName;
		}

		private $name; //Displayname of the parameter
		private $dbName; //Name of the parameter in the database
	}

	$parameters = array();
	$parameters[0] = new Parameter("Parameter 1", "param1");
	$parameters[1] = new Parameter("Parameter 2", "param2");
	$parameters[2] = new Parameter("Parameter 3", "param3");
	$parameters[3] = new Parameter("Parameter 4", "param4");
?>