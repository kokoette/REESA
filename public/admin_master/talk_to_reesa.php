<?php require_once('../../private/initialize.php'); ?>
<?php //user();?>
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
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Talk to Reesa</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Talk to Reesa</li>
                    </ol>
                </div>
            </div>

            <div class="container-fluid">
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



            </div>

            <?php include("includes/dashboard_footer.php"); ?>
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->

<?php include("includes/footer.php"); ?>