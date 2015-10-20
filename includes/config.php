<?php

ob_start(); //starts output buffering so headers can be used anywhere
session_start(); //start seesion will be needed for admin area

//database credentials
define('DBHOST', 'localhost');
define('DBUSER', 'jacobvarner');
define('DBPASS', 'Pi31415926');
define('DBNAME', 'jacobvar_JUNGLE_TIMES');

$db = new PDO("mysql:host=" . DBHOST . ";port=8889;dbname=" . DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//set timezone
date_default_timezone_set('America/Chicago');

//load classes as needed
function __autoload($class) {
	$class = strtolower($class);

	$classpath = 'classes/class.' . $class . '.php';
	if (file_exists($classpath)) {
		require_once $classpath;
	}

	$classpath = '../classes/class.' . $class . '.php';
	if (file_exists($classpath)) {
		require_once $classpath;
	}

	$classpath = '../../classes/class.' . $class . '.php';
	if (file_exists($classpath)) {
		require_once $classpath;
	}
}

$user = new User($db);

include 'functions.php';

?>