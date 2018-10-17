<?php require_once('../../private/initialize.php'); ?>
<?php require_login();?>
<?php //reesa(); ?>
<?php
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
                    <h3 class="text-primary">Reesa's Customers</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Reesa's Customers</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

                <!-- Start Page Content -->




                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Full Name</small></th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>
                                                    <th>Role</th>
                                                    <th>No. of Listings</th>
                                                    <th>Ongoing</th>
                                                    <th>Completed</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $all_persons = SystemUsers::find_all();
                                                foreach ($all_persons as $person) {
                                                    $all_propty = Property::num_propty_user_id($person->id);
                                                    $comp_trans = Property::all_completed_num($person->id, 1);
                                                    $ong_trans = Property::all_completed_num($person->id, 0);
                                                    ?>
                                                            <tr>
                                                                <td style="text-align: center;">
                                                                    <div class="round-img">
                                                                        <a href="">
                                                                            <?php if($person->profile != '') {echo '<img src="../backend/images/profile/'. $person->profile .'" alt="">'; } else {echo '<i class="fa fa-user-circle-o f-s-30" style="vertical-align: middle;"></i>';} ?>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td><?php echo $person->full_name ?></td>
                                                                <td><?php echo $person->email ?></td>
                                                                <td><?php echo $person->phone ?></td>
                                                                <td><?php echo $person->address ?></td>
                                                                <td><?php echo ($person->role_id == '2') ? 'Lister' : 'User' ?></td>
                                                                <td><?php echo $all_propty?></td>
                                                                <td><?php echo $ong_trans?></td>
                                                                <td><?php echo $comp_trans ?></td>
                                                            </tr>
                                                <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Page Content -->

        </div>

        <!-- End Page wrapper  -->

<?php
$footer_cust_lib = '
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script> 
';
?>
<?php include("includes/footer.php"); ?>