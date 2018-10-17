<?php

function require_login() {
	global $session;
	if(!$session->is_logged_in()) {
		redirect_to('../design_system/login.php');
	} else {

	}
}

function reesa() {
	global $session;
	if(!SystemUsers::is_reesa()) {
		redirect_to('../design_system/login.php');
	}
}

function lister() {
	global $session;
	if(!SystemUsers::is_lister()) {
		redirect_to('../design_system/login.php');
	}
}

function user() {
	global $session;
	if(!SystemUsers::is_user()) {
		redirect_to('../design_system/login.php');
	}
}


function display_session_message($error=NULL) {
  global $session;
  $msg = $session->message();
  if(isset($msg) && $msg != '') {
    $session->clear_message();

  	if(strpos($msg, 'Error') !== false) {
	  	return '<script type="text/javascript">
	        		fehler("'. escape($msg) .'");
	        	</script>';
  	} else {
	  	return '<script type="text/javascript">
	        		erfolg("'. escape($msg) .'");
	        	</script>';	
  	}
  }

}


function escape($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
  // if($_SERVER['REQUEST_METHOD'] == 'POST') {
  //   return true;
  // }
}

function redirect_to($location) {
  header("Location: " . $location);
  exit();
}

	//test
	function pr($val) {
		echo "<pre>";
		print_r($val);
		echo "</pre>";
	}

?>