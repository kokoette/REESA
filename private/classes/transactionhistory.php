<?php

class TransactionHistory extends DatabaseObject {

	static protected $table_name = "transaction_history";
	//static protected $db_columns = ['id', 'user_id', 'property_id', 'lister_id', 'amount_charged', 'date_time'];


	public $id;
	public $user_id;
	public $property_id;
	public $lister_id;
	public $amount_charged;
	public $date_time;

	public $address;
	public $display;
	public $full_name;

	static public function get_trans_history($role, $limit) {
		if($role == 'lister') {
			$trans_person = 'user_id';
		} else if($role == 'user') {
			$trans_person = 'lister_id';
		}

		$sql = "SELECT `transaction_history`.`id`, `transaction_history`.`user_id`, `transaction_history`.`property_id`, `transaction_history`.`lister_id`, `transaction_history`.`amount_charged`, `transaction_history`.`date_time`, `properties`.`address`, `properties`.`display`, `system_users`.`full_name` FROM `transaction_history` LEFT JOIN (`properties`, `system_users`) ON `transaction_history`.`property_id` = `properties`.`id` AND `transaction_history`.`". $trans_person ."` = `system_users`.`id` WHERE (`transaction_history`.`user_id` = ". $_SESSION['sys_user_id'] .") OR (`transaction_history`.`lister_id` = ". $_SESSION['sys_user_id'] .") ".$limit;
		$obj_result = static::find_by_sql($sql);
		if(!empty($obj_result)) {
			return $obj_result;
		} else {
			return false;
		}
	}


//diff class
	static public function set_trans_to_read() {
		$sql = "UPDATE notifications SET viewed = 1 WHERE sys_user_id = ".$_SESSION['sys_user_id'];
		$result = self::$database->query($sql);
		return ($result) ? true : false;
	}

	static public function get_unread_noti_no() {
		$sql = "SELECT * FROM notifications WHERE sys_user_id=" . $_SESSION["sys_user_id"] . " AND viewed = 0";
        $result = self::$database->query($sql);
        if($result->num_rows) {
        	return true;
        }else {
        	return false;
        }
	}

	static public function my_unread_pending($noti_type) {
		$sql = "SELECT * FROM notifications WHERE sys_user_id=" . $_SESSION["sys_user_id"] . " AND noti_type = '". $noti_type ."' AND viewed = 0";
		return self::find_by_sql($sql);
	}

}

?>