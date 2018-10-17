<?php

class DatabaseObject {

	static protected $database;
	static protected $table_name = "";
	static protected $db_columns = [];
	public $errors = [];



	static public function set_database($database) {
		self::$database = $database;
	}

	static public function find_by_sql($sql) {
		$result_query = self::$database->query($sql);
		if(!$result_query) {
			exit("Database query failed.");
		}

		$obj_arry = [];
		while ($record = $result_query->fetch_assoc()) {			
			$obj_arry[] = static::instantiate($record);
		}

		$result_query->free();
		return $obj_arry;
	}

	static public function find_by_id($id) {
		$sql = "SELECT * FROM " . static::$table_name . " WHERE id ='" . self::$database->escape_string($id) . "'";
		$obj_arry = static::find_by_sql($sql);
		if(!empty($obj_arry)) {
			return array_shift($obj_arry);
		} else {
			return false;
		}
	}


	static public function find_all() {
		$sql = "SELECT * FROM " . static::$table_name;
		return static::find_by_sql($sql);
	}

	static public function instantiate($record) {
		$prop_obj = new static;
		foreach ($record as $property => $value) {
			if(property_exists($prop_obj, $property)) {
				$prop_obj->$property = $value;	
			}
		}
		return $prop_obj;
	}

	public function merge_attrib($args=[]) {
		foreach ($args as $key => $value) {
			if(property_exists($this, $key) && !is_null($value)) {
				$this->$key = $value;
			}
		}
	}

	protected function validate() {
		$this->errors = [];

		return $this->errors;
	}

	public function create() {
		$this->validate();
		if(!empty($this->errors)) { return false; }

		$attributes = $this->create_san_attributes();
		$sql = "INSERT INTO ". static::$table_name ." (";
		$sql .= join(', ', array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		$result = self::$database->query($sql);
		if($result) {
			$this->id = self::$database->insert_id;
		}
		return $result;
	}


	public function create_san_attributes() {
		$attributes = [];
		foreach (static::$db_columns as $value) {
			if ($value == 'id') { continue; }
			$attributes[$value] = self::$database->escape_string($this->$value);
		}
		return $attributes;
	}

	public function delete() {
		$sql = "DELETE FROM ". static::$table_name ." WHERE id = '". self::$database->escape_string($this->id) ."' LIMIT 1";
		$result = self::$database->query($sql);
		return $result;
	}



	// static public function confirm($obj_arry) {
	// 	if(!empty($obj_arry)) {
	// 		echo 'admin'; //return true;
	// 	} else {
	// 		echo "Nein admin"; //return false;
	// 	}			
	// }



}

?>