<?php require_once('../../private/initialize.php');

require_login();


$logged_sys = $sys_users = SystemUsers::get_logged_sys_user();
//$sys_users = new SystemUsers;

if(is_post_request()) {
    $sys_users = new SystemUsers;

    $args = [];
    $args['full_name'] = $_POST['full_name'] ?? NULL;
    $args['email'] = strtolower($_POST['email']) ?? NULL;
    $args['address'] = $_POST['address'] ?? NULL;
    $args['phone'] = $_POST['phone'] ?? NULL;
    $args['profile'] = $_FILES['profile'] ?? NULL;

    $sys_users->merge_attrib($args);
    $updt_profile = $sys_users->validate_wt_file($logged_sys->profile, $logged_sys->email);
    if($updt_profile === true) {
        $session->message('Profile Edited Successfully');
        redirect_to('system_user_profile.php');
    }
}

$page_title = "Reesa.com My Dashboard";
$custom_css_library = '
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
                    <h3 class="text-primary">My Profile</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">My Profile</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <?php

                ?>
                    <?php echo display_errors($sys_users->errors); ?>
                <div class="row">
                    <!-- Column -->
                    
                    <!-- Column -->
                    <div class="col-md-11 dshPrfWrp">
                        <div class="row prfImgRw">
                            <div class="col-md-6 prfImgCol">
                                <div class="card-two">
                                    <header>
                                        <div class="prfl avatar">
                                            <?php if($logged_sys->profile != '') { echo '<img src="../backend/images/profile/'.$logged_sys->profile.'">'; } else {echo '<i class="fa fa-user-circle-o"></i>';} ?>
                                        </div>
                                    </header>
                                </div>
                                <?php if($sys_users->role_id == 1){echo '<p class="pflRlAdn">Role: Administrator</p>';} elseif($sys_users->role_id == 2){echo '<p>Role: Lister</p>';}elseif($sys_users->role_id == 3){echo '<p>Role: User</p>';} ?></p>
                            </div>
                            <div class="col-md-6 prfInpWrp dataTables_filter">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <p>Full name:</p>
                                        <input class="m-l-0" type="text" name="full_name" value="<?php echo escape($sys_users->full_name); ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <p>Email:</p>
                                        <input class="m-l-0" type="text" name="email" value="<?php echo escape($sys_users->email); ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <p>Address:</p>
                                        <input class="m-l-0" type="text" name="address" value="<?php echo escape($sys_users->address); ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <p>Phone:</p>
                                        <input class="m-l-0" type="text" name="phone" value="<?php echo escape($sys_users->phone); ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row prFlRw">
                                            <div class="col-md-4">
                                                Update Profile Picture
                                            </div>
                                            <div class="col-md-8">
                                                <input type="file" name="profile">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-block btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    
                    <!-- Column -->
                </div>

                <!-- End Page Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <?php include("includes/dashboard_footer.php"); ?>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->

<?php include("includes/footer.php"); ?>