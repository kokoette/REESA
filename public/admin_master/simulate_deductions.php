<?php require_once('../../private/initialize.php'); ?>


<?php
    $page_title = "Reesa.com My Dashboard";
    $custom_css_library = '
        <link href="css/lib/toastr/toastr.min.css" rel="stylesheet">
        <link href="css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
        <link href="css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
        <link href="css/lib/owl.carousel.min.css" rel="stylesheet" />
        <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" />
    ';
?>

        <!-- header header -->
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
                    <h3 class="text-primary">Simulate Deductions</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Simulate Deductions</li>
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
                            <div class="card-body">
                                <form action="../../private/periodic_deductions.php" method="post">
	                                <div class="col-12">
				                        <input class="btn btn-primary btn-block" value="SIMULATE" type="submit" name="">
				                   	</div>                               	
                                </form>
                            </div>
                        </div>
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