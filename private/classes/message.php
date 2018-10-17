<?php

class Message extends DatabaseObject {

	static protected $table_name = "message";
	static protected $db_columns = ['sender_id', 'receiver_id', 'property_id', 'subject', 'message', 'sender_view', 'receiver_view', 'sender_delete', 'receiver_delete', 'date_time'];

	public $id;
	public $sender_id;
	public $receiver_id;
	public $property_id;
	public $subject;
	public $message;
	public $sender_view;
	public $receiver_view;
	public $date_time;

	public $full_name;
	public $email;
	public $profile;



	public function __construct($args=[]) {
		$this->sender_id 	= $args['sender_id'] ?? '';
		$this->receiver_id 		= $args['receiver_id'] ?? '';
		$this->property_id 		= $args['property_id'] ?? '';
		$this->subject 		= $args['subject'] ?? '';
		$this->message 		= $args['message'] ?? '';
		$this->sender_view 	= $args['sender_view'] ?? '';
		$this->receiver_view 	= $args['receiver_view'] ?? '';
		$this->sender_delete 	= $args['sender_delete'] ?? '';
		$this->receiver_delete 	= $args['receiver_delete'] ?? '';
		$this->date_time 	= $args['date_time'] ?? '';
	}

	protected function validate() {
		if(is_blank($this->receiver_id)) {
	      $this->errors[] = "To cannot be blank.";
	    }
	    if(is_blank($this->subject)) {
	      $this->errors[] = "Subject cannot be blank.";
	    }
		if(is_blank($this->message)) {
	      $this->errors[] = "Message cannot be blank.";
	    }
	}

	static public function get_person_msg($prsn) {
		if($prsn == 'sender') {
			$person = 'sender_id';
			$person_delete = 'sender_delete';
		}else if($prsn == 'receiver') {
			$person = 'receiver_id';
			$person_delete = 'receiver_delete';
		}
		$sql = "SELECT * FROM ". static::$table_name ." WHERE ". $person ." = '". self::$database->escape_string($_SESSION['sys_user_id']) ."' AND ". $person_delete ." = '0'";
		$result = static::find_by_sql($sql);
		if($result) {
			return $result;
		}else {
			return false;
		}
	}

	static public function get_my_unread_msg() {
		$sql = "SELECT * FROM ". static::$table_name ." WHERE receiver_id = '". self::$database->escape_string($_SESSION['sys_user_id']) ."' AND receiver_view = 0 AND receiver_delete = '0'";
		$result = static::$database->query($sql);
		if($result->num_rows) {
			$row = static::find_by_sql($sql);
			return $row;
		}else {
			return false;
		}		
	}

	static public function get_message_by_id($msg_id, $person) {


		$sql = "SELECT `message`.`id`,`message`.`sender_id`, `message`.`receiver_id`, `message`.`property_id`, `message`.`subject`, `message`.`message`, `message`.`sender_view`, `message`.`receiver_view`, `message`.`sender_delete`, `message`.`receiver_delete`, `message`.`date_time`, `system_users`.`full_name`, `system_users`.`email`, `system_users`.`profile` FROM `". static::$table_name ."` LEFT JOIN `system_users` ON `message`.`". $person ."` = `system_users`.`id` WHERE `message`.`id` = '" . self::$database->escape_string($msg_id) . "' LIMIT 1";
		 $obj_arry = static::find_by_sql($sql);
		if(!empty($obj_arry)) {
			return array_shift($obj_arry);
		} else {
			return false;
		}
	}

	static public function is_my_message($msg_id) {
		$sql = "SELECT * FROM ". static::$table_name ." WHERE id = ". self::$database->escape_string($msg_id) ." AND (receiver_id = '". self::$database->escape_string($_SESSION['sys_user_id']) ."' OR sender_id = '". self::$database->escape_string($_SESSION['sys_user_id']) ."') LIMIT 1";
		$result = self::$database->query($sql);
		if($result->num_rows) {
			return true;
		} else {
			return false;
		}
	}

	public function set_read($pos) {
		if($pos == 'receiver') {
			$position = 'receiver_view';
		}else if($pos == 'sender') {
			$position = 'sender_view';
		}
		$sql = "UPDATE ". static::$table_name ." SET ". $position ." = '1' WHERE id = '". self::$database->escape_string($this->id) ."' LIMIT 1";
		$result = self::$database->query($sql);
		if($result) {
			return $result;
		}else {
			return false;
		}		
	}

	public function set_delete($person) {
		$sql = "UPDATE ". static::$table_name ." SET ". $person ." = '1' WHERE id = '". self::$database->escape_string($this->id) ."'";
		$result = self::$database->query($sql);
		return $result;
	}
}

?>