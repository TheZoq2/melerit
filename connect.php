<?php

define("DB_SERVER", "localhost");


define("DB_USER", "root");


define("DB_PASSWORD", "");

define("DB_NAME", "melerit2");
//define("DB_NAME", "kursdata");

define("DB_TIMEZONE", "Europe/Stockholm");

function getDbh() 
{
	static $dbh;
	if (is_null($dbh)) 
	{ 
		$dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_SERVER . ';charset=utf8'; 
		$attributes = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);

		try {
			$dbh = new PDO($dsn, DB_USER, DB_PASSWORD, $attributes);
			if (empty($dbh)) 
			{
				throw new Exception("Could not connect to the database");
			}
		} 
		catch (Exception $e) 
		{
			throw new Exception('Connection failed: ' . $e->getMessage());
		}
	}
	return $dbh;
}