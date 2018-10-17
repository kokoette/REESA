<?php 
require_once('../private/initialize.php');


if(!$session->is_logged_in()) {
    redirect_to('../public/design_system/login.php');
}

if(!SystemUsers::is_user()) {
	$session->message('Error: Sign in as a user to purchase property');
	redirect_to('../public/design_system/login.php');
}


if(isset($_GET['psy'])) {
	$get_id = escape($_GET['psy']);
	if(Property::is_ongin_compt($get_id)) {
	    $session->message('Error- Property already in transaction');
	    redirect_to('../public/admin_master/index.php');
	}
	//find in db or redirect
	$property = Property::find_by_id($get_id);
	if($property == false) {
		redirect_to('../public/design_system/login.php');
	}
	if(!$session->is_user()) {
		echo "redirecting";
	}

	//die(pr($_SESSION));
	if($property->send_offer()) {


		$to_id = $property->lister_id;
		$title = 'New property request';
		$message = 'You have a new property request from '.$_SESSION['full_name'];
		
		$noti_type = 'propty_request';
		
		$class = 'request';
		$page = 'pending_offers';
		$date_time = 9024808;
		$viewed = 0;

		send_notification($to_id, $title, $message, $noti_type, $class, $page, $date_time, $viewed, $database);


		$session->message('Your request has been sent pending response from the owner of this property');
		redirect_to('../public/admin_master/pending_offers.php');
	} else {
		echo 'in erreur';
	}


}else {
	redirect_to('../public/design_system/login.php');
}






function send_notification($sys_user_id, $title, $message, $noti_type, $class, $page, $payment_date_time, $viewed, $database) {
				$sql4 = "INSERT INTO notifications(sys_user_id, title, message, noti_type, class, page, date_time, viewed) VALUES('". $sys_user_id ."', '". $title ."', '". $message ."', '". $noti_type ."', '". $class ."', '". $page ."', '". $payment_date_time ."', '0')";
				$result4 = $database->query($sql4);
				if($result4) {
					return true;
				} else {
					return false;
				}
			}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
</head>
<body style="font-family: verdana;">
	
</body>
</html>
<?php
$database->close();
?>