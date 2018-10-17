<?php require_once('../../private/initialize.php'); ?>
<?php //user();?>
<?php
$page_title = "Reesa.com My Dashboard";

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
                    <h3 class="text-primary">Banks & Cards</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Banks & Cards</li>
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
                                <h4 class="m-0"><small>USED PAYMENTS</small></h4>
                                <hr class="m-b-2 m-t-2">
                            </div>
                            <div class="card-body">
                                <div class="card-content">
                                    <h5 class="m-b-2 m-t-5">Mastercard XXXX-5478</h5>
                                    <p><small>Exp: 12/19</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                   <div class="col-6">
                        <div class="card">
                            <div class="card-title">
                                <h4 class="m-0"><small>NEW PAYMENT METHOD</small></h4>
                                <hr class="m-t-2">
                            </div>
                            <div class="card-body">
                                <div class="row card-content">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control input-default" name="" placeholder="Card Number">
                                    </div>

                                    <div class="col-lg-12 m-t-10 m-b-2 m-r-5">
                                        <p><small>Expiry Date</small></p>
                                    </div>

                                    <div class="col-lg-3 p-r-5">
                                        <input type="text" class="form-control input-default" name="" placeholder="Month">
                                    </div>
                                    <div class="col-lg-3 p-l-0">
                                        <input type="text" class="form-control input-default" name="" placeholder="Year">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control input-default" name="" placeholder="CVV">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                   <div class="col-6">
                        <input class="btn btn-primary btn-block" value="UPDATE" type="submit" name="">
                   </div>
               </div>
                <!-- End PAge Content -->
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
