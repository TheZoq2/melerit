<?php
	class Parameter
	{
		function __construct($name, $dbName)
		{
			$this->name = $name;
			$this->dbName = $dbName;
		}
		public function getName()
		{
			return $this->name;
		}
		public function getDbName()
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

	class HTMLData
	{
		function __construct()
		{
			$this->passedClass = "resultPassed";
			$this->okClass = "resultOk";
			$this->failedClass = "resultFailed";
		}

		public function getPassedClass()
		{
			return $this->passedClass;
		}
		public function getOkClass()
		{
			return $this->okClass;
		}
		public function getFailedClass()
		{
			return $this->failedClass;
		}


		private $passedClass;
		private $okClass;
		private $failedClass;
	}

	$htmlData = new HTMLData();
?>