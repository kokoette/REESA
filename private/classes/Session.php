<?php

class Session {

	private $sys_user_id;
	public $full_name;
	public $profile;

	public function __construct() {
		session_start();
		$this->check_stored_login();
	}

	public function login($sys_user) {
		if($sys_user) {
			// prevent session fixation attacks
			session_regenerate_id();
			$this->sys_user_id = $_SESSION['sys_user_id'] = $sys_user->id;
			$this->full_name = $_SESSION['full_name'] = $sys_user->full_name;
			$this->profile = $_SESSION['profile'] = $sys_user->profile;
		}
		return true;
	}

	public function is_logged_in() {
		//check session id in db everytime
		return isset($this->sys_user_id);
	}

	public function logout() {
		unset($_SESSION['sys_user_id']);
		unset($_SESSION['full_name']);
		unset($this->sys_user_id);
		unset($this->full_name);
		unset($this->profile);

		return true;
	}

	private function check_stored_login() {
		if(isset($_SESSION['sys_user_id'])) {
			$this->sys_user_id = $_SESSION['sys_user_id'];
			$this->full_name = $_SESSION['full_name'];
		}
	}

	public function message($msg="") {
		if(!empty($msg)) {
			$_SESSION['message'] = $msg;
			return true;
		}else {
			return $_SESSION['message'] ?? '';
		}
	}

	// public function setMsgClas($clas="success") {
	// 	$_SESSION['msg_class'] = $clas;
	// 	return true;
	// }

	public function frst_wlm_msg() {
		if(isset($_SESSION['wlcm_msg']) && $_SESSION['wlcm_msg'] == $_SESSION['sys_user_id']) {
			unset($_SESSION['wlcm_msg']);
			// return '
			// 		<div id="fstWlcm" class="card wlcmWrp">
	        //             <div class="row wlcmTp">
	        //                 <div class="col-md-12">
	        //                     <i id="clWlcm" class="fa fa-close"></i>
	        //                     <h4 class="m-t-0">Welcome</h4>
	        //                     <p>Ich Liebe dich aber. At Reesa we strive to give you the best in blah   Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
	        //                 </div>
	        //             </div>
	        //             <hr>
	        //             <div class="row wlcmBtm">
	        //                 <div class="col-md-5">
	        //                     1/3
	        //                 </div>
	        //                 <div class="col-md-7 wlCBNxt">
	        //                     <input id="wlcNext" class="btn btn-dark btn-outline" type="button" value="next" name="">
	        //                 </div>
	        //             </div>
	        //         </div>
			// ';
		}
	}

	public function clear_message() {
		unset($_SESSION['message']);
	}

	public function is_lister() {
		if(!$this->is_logged_in()) {
			return false;
		}
		return true;
	}

	public function is_user() {
		if(!$this->is_logged_in()) {
			return false;
		}
		return true;
	}

}

?>
