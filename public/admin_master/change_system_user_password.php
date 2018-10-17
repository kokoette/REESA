<?php require_once('../../private/initialize.php'); 

require_login();


$errors = [];
$old_password = '';
$new_pass = '';
$new_pass_again = '';

if(is_post_request()) {
    $old_password = $_POST['val-old-password'] ?? '';
    $new_pass = $_POST['val-password'] ?? '';
    $new_pass_again = $_POST['val-confirm-password'] ?? '';

    if(is_blank($old_password)) {
        $errors[] = "Old password cannot be blank.";
    }
    if(is_blank($new_pass)) {
        $errors[] = "New password cannot be blank.";
    } elseif (!has_length($new_pass, array('min' => 4))) {
        $errors[] = "New password must contain 4 or more characters";
    }
    if($new_pass !== $new_pass_again) {
        $errors[] = "New password and New password again must match";
    }

    if(empty($errors)) {

        $sys_user = SystemUsers::find_by_id($_SESSION['sys_user_id']);
        if($sys_user != false && $sys_user->verify_password($old_password)) {
            $sys_user->password = $new_pass;
            
            if($sys_user->change_password()) {
                $session->message('Your password was successfully changed');
                redirect_to('system_user_profile.php');
            } else {
                $errors[]="Sorry Could not change you password. Please try again.";  
            }

        } else {
            $errors[]="Your old password is incorrect.";
        }
    }
}

$page_title = "Reesa.com My Dashboard";
$custom_css_library = '
  <link href="../design_system/css/validate.css" rel="stylesheet">
';
?>
<?php include("includes/header.php"); ?>
<!-- End header header -->

        <!-- Left Sidebar  -->
        <?php include("includes/sidebar.php"); ?>
        <!-- End Left Sidebar  -->

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Change Password</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

<?php

?>

                <!-- Start Page Content -->
                <div class="container-fluid">
                    <?php echo display_errors($errors); ?>
                    <form class="form-valide" action="" method="post">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                             <div class="row card-content">

                                                <div class="form-group col-lg-12 m-b-0">
                                                    <div>
                                                        <input type="password" class="form-control input-default" name="val-old-password" placeholder="Old Password*">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                             <div class="row card-content">
                                                <div class="form-group col-lg-12">
                                                    <div>
                                                        <input type="password" class="form-control input-default" name="val-password"  id="val-password" placeholder="New Password*">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group col-lg-12">
                                                    <div class="">
                                                        <input type="password" class="form-control input-default" name="val-confirm-password" placeholder="New Password again*">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                           <div class="col-6">
                                <input class="btn btn-primary btn-block" type="submit" value="Change Password" name="chang_pass">
                           </div>
                       </div>
                    </form>
                </div>

        </div>

        <!-- End Page wrapper  -->

<?php
	$footer_cust_lib = '
      <script src="../design_system/js/validate/jquery.validate.min.js"></script>
      <script src="../design_system/js/validate/jquery.validate-init.js"></script>
	';
?>

<?php include("includes/footer.php"); ?>