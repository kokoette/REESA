<?php

class SystemUsers extends DatabaseObject {

	static protected $table_name = "system_users";
	static protected $db_columns = ['full_name', 'email', 'phone', 'address', 'hashed_password', 'role_id', 'profile'];

	public $id;
	public $full_name;
	public $email;
	public $phone;
	public $address;
	protected $hashed_password;
	public $password;
	public $confirm_password;
	public $role_id;
	public $profile;
	protected $password_required = true;
	protected $uniq_email_valid = true;

	public $status;

	public function __construct($args=[]) {
		$this->full_name 	= $args['full_name'] ?? '';
		$this->email 		= $args['email'] ?? '';
		$this->phone 		= $args['phone'] ?? '';
		$this->address 		= $args['address'] ?? '';
		$this->password 	= $args['password'] ?? '';
		$this->confirm_password 	= $args['confirm_password'] ?? '';
		$this->role_id 		= $args['role_id'] ?? '';
	}

	static public function get_logged_sys_user() {
		$result = self::find_by_id($_SESSION['sys_user_id']);
		return $result;
	}

	protected function set_hashed_password() {
		$this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
	}

	public function verify_password($password) {
		return password_verify($password, $this->hashed_password);
	}

	public function change_password() {
		$this->set_hashed_password();
		$sql = "UPDATE system_users SET hashed_password = '". $this->hashed_password ."' WHERE id = '". $this->id ."' LIMIT 1";
		$result = self::$database->query($sql);
		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	static public function find_row_all() {
		$sql = "SELECT * FROM system_users";
		$result = self::$database->query($sql);
		return $result;
	}

	protected function validate() {
		$this->errors = [];

	    if(is_blank($this->full_name)) {
	      $this->errors[] = "Full name cannot be blank.";
	    } elseif (!has_length($this->full_name, array('min' => 2, 'max' => 255))) {
	      $this->errors[] = "Full name must be between 2 and 255 characters.";
	    }

	    if($this->uniq_email_valid) {
		    if(is_blank($this->email)) {
		      $this->errors[] = "Email cannot be blank.";
		    } elseif (!has_length($this->email, array('max' => 255))) {
		      $this->errors[] = "Email must be less than 255 characters.";
		    } elseif (!has_valid_email_format($this->email)) {
		      $this->errors[] = "Email must be a valid format.";
		    } elseif (!has_unique_email($this->email, $this->id ?? 0)) {
				$this->errors[] = "Email is in use Try another.";
			}
		}

		if(is_blank($this->phone)) {
			$this->errors[] = "Phone cannot be blank";
		}
		
		if(is_blank($this->address)) {
			$this->errors[] = "Address cannot be blank";
		}

		if($this->password_required) {
			if(is_blank($this->password)) {
				$this->errors[] = "Password cannot be blank.";
			} elseif (!has_length($this->password, array('min' => 4))) {
				$this->errors[] = "Password must contain 4 or more characters";
			}

			if(is_blank($this->confirm_password)) {
				$this->errors[] = "Confirm password cannot be blank.";
			} elseif ($this->password !== $this->confirm_password) {
				$this->errors[] = "Password and Password again must match.";
			}
		}
		// if($this->password_required == false) {
		// 	echo 'File not found';
		// }

		return $this->errors;
	}

	public function update() {

		$san_attrib = $this->create_san_attributes();
		$attrib_pairs = [];
		foreach ($san_attrib as $key => $value) {
			if($value == '') {continue;}
			$attrib_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ". static::$table_name ." SET ";
		$sql .= join(', ', $attrib_pairs);
		$sql .= " WHERE id = '" . self::$database->escape_string($this->id) . "' ";
		$sql .= "LIMIT 1";
		$result = self::$database->query($sql);
		return $result;		
	}

	public function validate_wt_file($old_profl, $old_email) {
		//pr($this);
		//echo $old_email.'<br/>';
		//echo $this->email.'<br/>';
		if($old_email == $this->email) {
			$this->uniq_email_valid = false;
		}
		$this->password_required = false;
		$this->validate();
		$this->id = $_SESSION['sys_user_id'];

		if(!empty($this->profile['name'])) {
			//echo 'Ich liebe dich';
			$file_name = $this->profile['name'];
			$file_tmp = $this->profile['tmp_name'];
			$file_size = $this->profile['size'];
			$file_error = $this->profile['error'];

			$file_ext = explode('.', $file_name);
			$file_ext = strtolower(end($file_ext));

			$allowed = array('jpg', 'jpeg', 'gif', 'png');

			if(in_array($file_ext, $allowed)) {
				if($file_error === 0) {
					if($file_size <= 2097152) {

						//echo uniqid();
						$file_name_new = uniqid() . '.' . $file_ext;
						$file_destination = '../backend/images/profile/'.$file_name_new;

						if(empty($this->errors)) {
							$this->profile = $file_name_new;
							//pr($this);
							echo $old_profl;
							if(move_uploaded_file($file_tmp, $file_destination)) {
								$this->update();
								$_SESSION['profile'] = $file_name_new;
								unlink('../backend/images/profile/'.$old_profl);
								return true;
							} else {
								$this->errors[] = "Could not upload file, please try again";
							}
						}

					} else {
						$this->errors[] = "[".$file_name."] is too large, maximum file size is 2MB.";
					}
				} else {
					$errors[] = "[{$file_name}] errored with code {$file_error}";
				}
			}else {
				$this->errors[] = "[{$file_name}] file extension '{$file_ext}' is not allowed";
			}
		} else {
			//pr($this);
			if(empty($this->errors)) {
				$this->profile = NULL;
				$this->update();
				return true;
			}
		}

		if(!empty($this->errors)) {
			return $this->errors;
		}
		//[{$file_name}] file extension '{$file_ext}' is not allowed
	}

	public function create() {
		$this->set_hashed_password();
		return parent::create();
	}

	//static public function all_users

	// static public function all_users() {
	// 	$sql = "SELECT `system_users`.`id`, `system_users`.`full_name`, `system_users`.`phone`, `system_users`.`email`, `properties`.`status` FROM `system_users` LEFT JOIN `properties` ON `system_users`.`id` = `properties`.`lister_id` WHERE `system_users`.`id` = '16'";
	// 	$result = static::find_by_sql($sql);
	// 	//pr($result);
	// 	if(!empty($result)) {
	// 		pr($result);
	// 	} else {
	// 		return false;
	// 	}
	// }

	static public function find_by_email($email) {
		$sql = "SELECT * FROM " . static::$table_name . " WHERE email ='" . self::$database->escape_string($email) . "'";
		$obj_arry = static::find_by_sql($sql);
		if(!empty($obj_arry)) {
			return array_shift($obj_arry);
		} else {
			return false;
		}		
	}
	static public function is_reesa() {
		$sql = "SELECT role_id FROM ". static::$table_name ." WHERE id = '". $_SESSION['sys_user_id'] ."' AND role_id = 1";
		$result = self::$database->query($sql);
		if($result->num_rows) {
			return true;
		} else {
			return false;
		}
	}
	static public function is_lister() {
		$sql = "SELECT role_id FROM ". static::$table_name ." WHERE id = '". $_SESSION['sys_user_id'] ."' AND role_id = 2";
		$result = self::$database->query($sql);
		if($result->num_rows) {
			return true;
		} else {
			return false;
		}
	}
	static public function is_user() {
		$sql = "SELECT role_id FROM ". static::$table_name ." WHERE id = '". $_SESSION['sys_user_id'] ."' AND role_id = 3";
		$result = self::$database->query($sql);
		if($result->num_rows) {
			return true;
		} else {
			return false;
		}
	}
}

?>
