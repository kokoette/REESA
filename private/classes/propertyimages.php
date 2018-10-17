<?php

class PropertyImages extends DatabaseObject {
	static protected $table_name = "property_images";

	public $id;
	public $lister_id;
	public $property_id;
	public $timestamp;
	public $ext;
	public $address;
	public $area;
	public $bed;
	public $bath;
	public $no_years;
	public $price;
	public $display;
	public $is_display;

	static public function get_property_images($propty_id) {
		$sql = "SELECT * FROM ". static::$table_name ." WHERE property_id = '". self::$database->escape_string($propty_id) ."'" ;
		$obj_arry = static::find_by_sql($sql);
		if($obj_arry) {
			return $obj_arry;
		} else {
			return false;
		}
	}

	public function delete() {
		$sql = "DELETE FROM ". static::$table_name ." WHERE id = '". $this->id ."' AND lister_id = '".$_SESSION['sys_user_id'] . "' LIMIT 1";
		$result = self::$database->query($sql);
		return $result;
	}

	public function remove_image() {
		$img_path = $this->property_id.'/'.$this->id.'.'.$this->ext;
		unlink('../backend/images/lister/'.$img_path);
	}

}

?>