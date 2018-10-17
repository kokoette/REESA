<?php

class PropertyTransDetails extends DatabaseObject {

	static protected $table_name = "propty_trans_details";
	static protected $db_columns = ['user_id', 'property_id', 'lister_id', 'start_property_price', 'property_balance', 'start_total_months', 'months_left', 'deduct_monthly', 'total_months_paid', 'total_paid_amount', 'completed'];

	public $id;
	public $user_id;
	public $property_id;
	public $lister_id;
	public $start_property_price;
	public $property_balance;
	public $start_total_months;
	public $months_left;
	public $deduct_monthly;
	public $total_months_paid;
	public $total_paid_amount;
	public $completed;


	static public function ongoin_offers($person) {
		$sql = "SELECT * FROM ". static::$table_name ." WHERE ". $person ." = ". $_SESSION['sys_user_id'] ." AND completed = 0";
		return self::find_by_sql($sql);		
	}
	static public function completed_trans($person) {
		$sql = "SELECT * FROM ". static::$table_name ." WHERE ". $person ." = ". $_SESSION['sys_user_id'] ." AND completed = 1";
		return self::find_by_sql($sql);		
	}



}