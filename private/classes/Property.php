<?php

class Property {

	static protected $db_columns = ['lister_id', 'address', 'state', 'area', 'bed', 'bath', 'amenities', 'description', 'sale_rent', 'no_years', 'price'];
	public $errors = [];

	static protected $database;
	public $id;
	public $lister_id;
	public $address;
	public $state;
	public $area;
	public $bed;
	public $bath;
	public $amenities;
	public $description;
	public $sale_rent;
	public $no_years;
	public $no_months;
	public $price;
	public $files;
	public $offer;
	public $status;
	public $featured;
	public $draft;
	public $display;
	protected $file_required = true;
	public $up_new_prop = true;

	public $keywords;
	public $number_rows;

	public function __construct($args=[]) {
		$this->lister_id 	= $args['lister_id'] ?? '';
		$this->address 		= $args['address'] ?? '';
		$this->state 		= $args['state'] ?? '';
		$this->area 		= $args['area'] ?? '';
		$this->bed 			= $args['bed'] ?? '';
		$this->bath 		= $args['bath'] ?? '';


		if(isset($args['amenities'])) {
			$this->amenities 	= $args['amenities'];
		} else{
			$this->amenities 	= [];
		}

		$this->description 	= $args['description'] ?? '';
		$this->no_years 	= $args['no_years'] ?? '';
		$this->price 		= $args['price'] ?? '';

		if(isset($args['sale_rent'])) {
			$this->sale_rent = $args['sale_rent'];
		}else {
			$this->sale_rent 	= [];
		}

		$this->files 		= $args['files'] ?? '';
	}

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
			$obj_arry[] = self::instantiate($record);
		}
		$result_query->free();
		return $obj_arry;
	}

	static public function find_all_by_id($id, $draft, $status) {
		$sql = "SELECT * FROM properties WHERE id ='" . self::$database->escape_string($id) . "' AND draft= '".$draft."' ".$status;
		$result_query = self::$database->query($sql);
		if(!$result_query) {
			exit("Database query failed.");
		}

		$obj_arry = [];
		while ($record = $result_query->fetch_assoc()) {			
			$obj_arry[] = self::instantiate($record);
		}
		$result_query->free();
		return $obj_arry;
	}	

	static public function find_by_id($id) {
		$sql = "SELECT * FROM properties WHERE id ='" . self::$database->escape_string($id) . "'";
		$obj_arry = self::find_by_sql($sql);
		if(!empty($obj_arry)) {
			return array_shift($obj_arry);
		} else {
			return false;
		}
	}

	static public function use_find_id($id) {
		$sql = "SELECT * FROM properties WHERE id ='" . self::$database->escape_string($id) . "' AND draft = 0 ";
		$obj_arry = self::find_by_sql($sql);
		if(!empty($obj_arry)) {
			return array_shift($obj_arry);
		} else {
			return false;
		}	
	}

	static public function real_find_id($id) {
		$sql = "SELECT * FROM properties WHERE id ='" . self::$database->escape_string($id) . "' AND draft = 0 AND status = '' ";
		$obj_arry = self::find_by_sql($sql);
		if(!empty($obj_arry)) {
			return array_shift($obj_arry);
		} else {
			return false;
		}		
	}

	static public function is_my_property($propty_id) {
		$sql = "SELECT * FROM properties WHERE id ='" . self::$database->escape_string($propty_id) . "' AND lister_id = '". $_SESSION['sys_user_id'] ."' LIMIT 1";
		$result = self::$database->query($sql);
		if($result->num_rows) {
			return true;
		} else {
			return false;
		}
	}

	static public function find_all() {
		$sql = "SELECT * FROM properties";
		return self::find_by_sql($sql);
	}

	static public function find_all_current_lister() {
		$sql = "SELECT `id`, `lister_id`, `address`, `state`, `area`, `bed`, `bath`, `amenities`, LEFT(`description`, 55) as `description`, `sale_rent`, `no_years`, `price`, `display`, `date_time` FROM properties WHERE lister_id ='" . $_SESSION['sys_user_id'] . "'";
		return self::find_by_sql($sql);
	}

	static public function find_featured() {
		$sql = "SELECT * FROM properties WHERE featured !='0' ORDER BY featured ASC";
		return self::find_by_sql($sql);
	}

	static public function find_not_featured() {
		$sql = "SELECT * FROM properties WHERE featured ='0'";
		return self::find_by_sql($sql);
	}

	static public function set_featured($propty_id, $feat) {
		$propty_id = self::$database->escape_string($propty_id);
		$feat = self::$database->escape_string($feat);

		$sql = "UPDATE properties SET featured = '". $feat ."' WHERE id = '". $propty_id ."'";
		$result = self::$database->query($sql);
		return $result;
	}

	static public function set_display($propty_id, $feat) {
		$propty_id = self::$database->escape_string($propty_id);
		$feat = self::$database->escape_string($feat);

		$sql = "UPDATE properties SET display = '". $feat ."' WHERE id = '". $propty_id ."'";
		$result = self::$database->query($sql);
		return $result;
	}

	static public function instantiate($record) {
		$prop_obj = new self;
		foreach ($record as $property => $value) {
			if(property_exists($prop_obj, $property)) {
				$prop_obj->$property = $value;	
			}
		}
		return $prop_obj;
	}

	protected function validate() {
		$this->errors = [];
		if(is_blank($this->address)) {
			$this->errors[] = "Address cannot be blank";
		}
		if(is_blank($this->state)) {
			$this->errors[] = "State cannot be blank";
		}		
		if(is_blank($this->area)) {
			$this->errors[] = "Area cannot be blank";
		}elseif($this->area < 1) {
			$this->errors[] = "Invalid area size";
		}
		if(is_blank($this->bed)) {
			$this->errors[] = "Bed cannot be blank";
		}
		if(is_blank($this->bath)) {
			$this->errors[] = "Bath cannot be blank";
		}
		if(is_blank($this->no_years)) {
			$this->errors[] = "Number of years cannot be blank";
		}
		if(is_blank($this->price)) {
			$this->errors[] = "Price cannot be blank";
		}else if($this->price < 1) {
			$this->errors[] = "Invalid price";
		}

		if(isset($this->amenities)) {
			if(empty($this->amenities)) {
				$this->errors[] = "Please select at least one Amenity";
			}
		}else {
			$this->errors[] = "Amenities not set";
		}
		if(isset($this->sale_rent)) {
			if(empty($this->sale_rent)) {
				$this->errors[] = "Please choose one of Rent or Sale";
			}
		}else {
			$this->errors[] = "Status not set";
		}		

		if($this->file_required) {
			if($this->prop_up_valid() !== true) {
				foreach ($this->prop_up_valid() as $new_errors) {
					$this->errors[] = $new_errors;
				}
			}
		}

		return $this->errors;
	}

	public function prop_up_valid(){

		$files = $this->files;

		$failed = array();

		$allowed = array('jpg', 'jpeg', 'png', 'gif');

		foreach ($files['name'] as $position => $file_name) {
			if(empty($file_name)) {
				$errors[] = "You have not selected any image";
			} else {
				$file_size = $files['size'][$position];
				$file_error = $files['error'][$position];

				$file_ext = explode('.', $file_name);
				$file_ext = strtolower(end(($file_ext)));

				if(in_array($file_ext, $allowed)) {

					if($file_error === 0) {

						if($file_size >= 2097152) {
							$errors[] = $failed[$position] = "[{$file_name}] is too large, maximum file size is 2MB.";
						}

					} else {
						$errors[] = $failed[$position] = "[{$file_name}] errored with code {$file_error}";
					}

				} else {
					$errors[] = $failed[$position] = "[{$file_name}] file extension '{$file_ext}' is not allowed";
				}	
			}
		}
		if (!empty($errors)) {
			return $errors;
		} else {
			return true;
		}
	}

	public function property_upload(){

		$files = $this->files;
		$failed = array();
					
		$last_image = array_pop($this->files['name']);
		$last_img_ext = explode('.', $last_image);
		$last_img_ext = strtolower(end(($last_img_ext)));

		foreach ($files['name'] as $position => $file_name) {
			$file_tmp = $files['tmp_name'][$position];
			$file_ext = explode('.', $file_name);
			$file_ext = strtolower(end(($file_ext)));



			$lister_id = $this->lister_id;
			$property_id = $this->id;
			$timestamp = 324220;

			$sql = "INSERT INTO `property_images` (lister_id, property_id, timestamp, ext) VALUES ('{$lister_id}', '{$property_id}', '{$timestamp}', '{$file_ext}')";
			$result = self::$database->query($sql);
			if(!$result) {
				//echo 'error';
			}
			$new_image_id = self::$database->insert_id;

			if($this->up_new_prop == true) {
				mkdir('../backend/images/lister/'.$property_id, 0744);
			}

			$file_name_new = $new_image_id . '.' . $file_ext;
			$file_destination = '../backend/images/lister/'. $property_id .'/' . $file_name_new;
			move_uploaded_file($file_tmp, $file_destination);
		}

			$last_img_id = self::$database->insert_id;

		if($this->up_new_prop == true) {
			$featured_file = $last_img_id.".".$last_img_ext;
			$dp_sql = "UPDATE properties SET display = '". $featured_file ."' WHERE id = '". $property_id ."'";
			$result = self::$database->query($dp_sql);
		}


		if (!empty($errors)) {
			return $errors;
		} else {
			return true;
		}		
	}

	public function create() {
		$this->validate();

												//$this->property_upload();


		if(!empty($this->errors)) { return false; }

		$attributes = $this->create_san_attributes();
		$sql = "INSERT INTO properties (";
		$sql .= join(', ', array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		$result = self::$database->query($sql);
		if($result) {
			$this->id = self::$database->insert_id;
		}


		$this->property_upload();

		return $result;
	}

	public function update() {
		$this->file_required = false;

		$this->validate();
		if(!empty($this->errors)) { return false; }

		$san_attrib = $this->create_san_attributes();
		$attrib_pairs = [];
		foreach ($san_attrib as $key => $value) {
			$attrib_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE properties SET ";
		$sql .= join(', ', $attrib_pairs);
		$sql .= " WHERE id = '" . self::$database->escape_string($this->id) . "' ";
		$sql .= "LIMIT 1";
		$result = self::$database->query($sql);
		return $result;
	}

	public function merge_attrib($args=[]) {
		foreach ($args as $key => $value) {
			if(property_exists($this, $key) && !is_null($value)) {
				$this->$key = $value;
			}
		}
	}

	public function create_san_attributes() {
		$attributes = [];
		foreach (self::$db_columns as $value) {
			if ($value == 'id') { continue; }
			$attributes[$value] = self::$database->escape_string($this->$value);
		}
		return $attributes;
	}

	public function send_offer() {
		//Cannot send more that one pending offer to the same listing
		//only users can send offer
		if($this->offer != '') {
			$upd_offer = $this->offer . ", " . $_SESSION['sys_user_id'];

		} else {
			$upd_offer = $_SESSION['sys_user_id'];
			//$upd_offer = '{"user_id": '. $_SESSION['sys_user_id'] .'}';
		}
		$sql = "UPDATE properties SET offer='". $upd_offer ."' WHERE id = '". $this->id ."' LIMIT 1";
		$result = self::$database->query($sql);
		if($result) {
			return $result;			
		} else {
			return false;		
		}
	}

	public function view_offers() {
		pr($this);
	}

	static public function prpty_offers_frm_usrs() {
		$sql = "SELECT * FROM properties WHERE offer != ''";
		return self::find_by_sql($sql);		
	}

	static public function curnt_listr_offers() {
		$sql = "SELECT * FROM properties WHERE lister_id ='" . $_SESSION['sys_user_id'] . "'" . "  AND offer != ''";
		// and role=user
		return self::find_by_sql($sql);
	}

	public function unset_profile() {
		$sql = "UPDATE properties SET display = '' WHERE id = '". $this->id ."' LIMIT 1";
		$result = self::$database->query($sql);
		if($result) {
			return $result;			
		} else {
			return false;		
		} 
	}

	static public function search_propty($keywords) {
		$returned_results = array();
		$where = "";

		$keywords = preg_split('/[\s]+/', $keywords);
		$total_keywords = count($keywords);

		foreach ($keywords as $key => $keyword) {
			$where .= "(`address` LIKE '%$keyword%' OR `description` LIKE '%$keyword%' OR `state` LIKE '%$keyword%') AND status=''";
			if($key != ($total_keywords - 1)) {
				$where .= " AND ";
			}
		}
		

		$sql = "SELECT `id`, `lister_id`, `address`, `state`, `area`, `bed`, `bath`, `amenities`, LEFT(`description`, 70) as `description`, `sale_rent`, `no_years`, `price`, `display`, `date_time`  FROM `properties` WHERE ".$where;
		$result_num = ($results = self::$database->query($sql)) ? $results->num_rows : 0 ;

		if($result_num === 0) {
			return false;
		} else {
			$search_obj = self::find_by_sql($sql);
			return $search_obj;
		}

		//echo $result_num;

	}

	public function delete_property() {
		$prop_imgs = PropertyImages::get_property_images($this->id);

		if($prop_imgs) {
			foreach ($prop_imgs as $prop_img) {
				echo $img_path = $prop_img->property_id.'/'.$prop_img->id.'.'.$prop_img->ext;echo '<br/>';
				unlink('../public/backend/images/lister/'.$img_path);
			}
		}
		$sql = "DELETE FROM properties WHERE id = '". $this->id ."' AND lister_id = '". $_SESSION['sys_user_id']."'";
		$result = self::$database->query($sql);

		$sql2 = "DELETE FROM property_images WHERE property_id = '". $this->id ."' AND lister_id = '". $_SESSION['sys_user_id']."'";
		$result = self::$database->query($sql2);
			
			
	}



	//move to New Class


	// static public function propterty_trans_details($detls_args=[]) {
	// 	pr($detls_args);
	// }
	static public function num_propty_user_id($lister_id) {
		$sql = "SELECT lister_id FROM properties WHERE lister_id = '". $lister_id ."'";
		$result = self::$database->query($sql);
		return $result->num_rows;		
	}

	static public function all_completed_num($lister_id, $status) {
		$sql = "SELECT lister_id FROM propty_trans_details WHERE lister_id = '". $lister_id ."' AND completed = '". $status ."'";
		$result = self::$database->query($sql);
		return $result->num_rows;
		//pr($result);
	}

	static public function person_trans_with($person) {
		if($person == 'lister') {
			$oda_persn = 'user_id';
			$to = 'lister_id';
		}elseif($person == 'user') {
			$oda_persn = 'lister_id';
			$to = 'user_id';
		}

		$sql = "SELECT * FROM propty_trans_details WHERE ".$oda_persn." = ".$_SESSION['sys_user_id']." GROUP BY ".$to;
		$result = self::$database->query($sql);
		return $result;
	}

	static public function get_property_images($id) {
		$sql = "SELECT * FROM property_images WHERE property_id ='". $id ."'";
		$result = self::$database->query($sql);
		if($result) {
			return $result->fetch_assoc();
		}else {
			//return error or
			return false;
		}
	}

	static public function is_ongin_compt($prop_id) {
		$sql = "SELECT * FROM propty_trans_details WHERE property_id ='". self::$database->escape_string($prop_id) ."'";
		$result = self::$database->query($sql);
		if($result->num_rows) {
			return true;
		} else {
			return false;
		}
	}

	static public function delete_request_noti() {
		$sql = "DELETE FROM notifications WHERE sys_user_id = ". $_SESSION['sys_user_id'] ." AND noti_type='propty_request'";
		self::$database->query($sql);
	}







}

?>
