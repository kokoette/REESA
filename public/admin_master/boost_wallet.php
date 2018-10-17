<?php require_once('../../private/initialize.php'); ?>
<?php require_login();?>
<?php user();?>
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
                    <h3 class="text-primary">Boost Wallet</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Boost Wallet</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                   <div class="col-6">
                        <div class="card">
                            <div class="card-title">
                                <h4 class="m-0"><small>Enter Amount to pay</small></h4>
                                <hr class="m-t-2">
                            </div>
                            <div class="card-body">
                                <div class="row card-content form-group">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control input-default" name="" placeholder="Amount">
                                    </div>

                                    <div class="col-lg-12 m-t-10 m-b-2 m-r-5">
                                    	<select class="form-control">
                                    		<option>Select Property to pay</option>
					                      	<option>Address | Price: N3,000,000 | Balance: 1,780,000 | Monthly payment: N20,000</option>
					                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                   <div class="col-6">
                        <input class="btn btn-primary btn-block" type="submit" value="Pay" name="">
                   </div>
               </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->

<?php include("includes/footer.php"); ?>