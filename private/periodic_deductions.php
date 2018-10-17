<?php 

require_once('../private/initialize.php'); 

$lister_id = $_SESSION['sys_user_id'];

$sql = "SELECT * FROM propty_trans_details GROUP BY property_id";

$result = $database->query($sql);
if($result) {

	while($row = $result->fetch_assoc()) {
		pr($row);
		$months_left = $row['months_left'];
		if($months_left != 0) {
			//must be user
			$id = $row['id'];
			$user_id = $row['user_id'];
			$property_id = $row['property_id'];
			$lister_id = $row['lister_id'];
			//pay deduct_monthly
			$deduct_monthly = $row['deduct_monthly'];

			$property_balance = $row['property_balance'];
			$property_balance = $property_balance - $deduct_monthly;

			$months_left = $months_left - 1;

			$total_months_paid = $row['total_months_paid'];
			$total_months_paid = $total_months_paid + 1;

			$total_paid_amount = $row['total_paid_amount'];
			$total_paid_amount = $total_paid_amount + $deduct_monthly;

			if($months_left == 0) {
				$completed = 1;
				$prop_status = '{"completed": 1}';
				$status_sql = "UPDATE properties SET status = '". $prop_status ."' WHERE id = ". $property_id ." LIMIT 1";
				$status_result = $database->query($status_sql);
				if(!$status_result) {
					die('Nein');
				}else {
					echo "true";
				}
			} else {
				$completed = $row['completed'];
			}
				
			//should i update here cos doesnt  change [completed] = 1
			//and balance == || < 0}
				//change property_price to property_balance.

			$sql2 = "UPDATE propty_trans_details SET property_balance='". $property_balance ."', months_left='". $months_left ."', total_months_paid='". $total_months_paid ."', total_paid_amount='". $total_paid_amount ."', completed='". $completed."' WHERE id = '". $id ."' LIMIT 1";

			$result2 = $database->query($sql2);
			if($result2) {
				//echo 'True';
			} else {
				echo "Nien";
			}
			$date_time = 45678768;
			$sql3 = "INSERT INTO transaction_history(user_id, property_id, lister_id, amount_charged, date_time) VALUES('". $user_id ."', '". $property_id ."', '". $lister_id ."', '". $deduct_monthly ."', '". $date_time ."')";
			$result3 = $database->query($sql3);
			if($result3) {
				//echo 'True';
			} else {
				echo "Nien";
			}

			$title = "New payment";
			$message = "A total of N". number_format($deduct_monthly, 2, '.', ',') ." has been payed.";

			$noti_type = 'money_transact';

			$class = "payment";
			$page = "transactions";
			$payment_date_time = '2nd Sept 2018';
			$viewed = 0;


			//use in send_request.php, place in class
			send_notification($user_id, $title, $message, $noti_type, $class, $page, $date_time, $viewed, $database);
			send_notification($lister_id, $title, $message, $noti_type, $class, $page, $date_time, $viewed, $database);

			pr($row);

		} else if($months_left == 0) {

		}
	}
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

header('Location: '.$_SERVER['HTTP_REFERER']);



?>