 <?php require_once('../private/initialize.php'); ?>

<?php

	if(isset($_GET['loschen'])) {

		$id = $_GET['loschen'];

		$to_del_obj = Property::find_by_id($id);

		if($to_del_obj->lister_id != $_SESSION['sys_user_id']) { redirect_to('../public/admin_master/index.php'); }
		if($to_del_obj->status == '') {
			$result = $to_del_obj->delete_property();
			$session->message('Property deleted successfully.');
			redirect_to('../public/admin_master/my_listings.php');
		}else {

			$session->message('Error: Cannot delete property once its been involved in a transaction.');
			redirect_to('../public/admin_master/my_listings.php');
		}

	}

?>