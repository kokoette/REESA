<?php
	ob_start();
	//escape all display on page

	//error_reporting(E_ALL);
	define("PRIVATE_PATH", dirname(__FILE__));
	//echo "Private path-> _ _ " . PRIVATE_PATH;

	define("PROJECT_PATH", dirname(PRIVATE_PATH));
	//echo "<br /> Project path-> _ _ " . PROJECT_PATH;

	define("PUBLIC_PATH", PROJECT_PATH . '/public');
	//echo "<br /> Public path-> _ _ " . PUBLIC_PATH . "<br />";
	
	$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
	$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
	define("WWW_ROOT", $doc_root);

	/*
	foreach (glob('classes/*.class.php') as $file) {
		require_once($file);
	}*/

	function my_autoload($class) {
		if(preg_match('/\A\w+\Z/', $class)) {
			include(dirname(__FILE__).'/classes/' . $class . '.php');
		}
	}
	spl_autoload_register('my_autoload');

	require_once('db_credentials.php');
	require_once('functions/database_function.php');
	require_once('functions/general.php');
	require_once('functions/validation_functions.php');

	$database = db_connect();
	Property::set_database($database);
	DatabaseObject::set_database($database);
	$session = new Session;
	
	
	//$database = db_connect();
	//DatabaseObject::set_database($database);


	//$database = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	//escape all display on page
	

?>