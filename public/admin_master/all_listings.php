<?php require_once('../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php //reesa(); ?>
<?php
    $page_title = "Reesa.com My Dashboard";
    $custom_css_library = '
    	<link href="css/lib/bootstrap/bootstrap-extend.min.css" rel="stylesheet">
        <link href="css/lib/modal/modals.css" rel="stylesheet">
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
            <div class="row page-titles al_list_tl">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">All Listings</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">All Listings</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

                <!-- Start Page Content -->

                <div class="container-fluid">
                    <div class="row ft_lst_wrp">
                        <div class="col-lg-6">
                            <a href="set_featured.php" class="label label-rouded label-primary"><i class="fa fa-check m-r-5"></i>Approve Listing</a>
                        </div>
                        <div class="col-lg-6">
                            <a href="set_featured.php" class="btn btn-dark btn-outline btn-rounded pull-right">Set Featured Listing</a>
                        </div>
                    </div>
			
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card p-t-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Address</th>
                                                    <th>Area</th>
                                                    <th>Bed</th>
                                                    <th>Bath</th>
                                                    <th>Price</th>
                                                    <th>Years</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

													$properties = Property::find_all();
														foreach ($properties as $property) {                          
                                                ?>

                                                        <tr>
                                                            <td>
                                                                <div class="rect-img">
                                                                    <a href="#"><img src="../backend/images/lister/<?php if($property->display != ''){echo $property->id.'/'.$property->display;}else{echo 'placeholder.png';}?>" alt=""></a>
                                                                </div>
                                                            </td>
                                                            <td><a href="../front_templated/view.php?liebe=<?php echo $property->id; ?>&eup=rsano3/listing/gs_l=16_erwidern_dreal+soluop=thisell/p350"><div> <?php echo $property->address . ' '; echo ($property->featured != 0) ? '&nbsp;&nbsp;<small><i class="fa fa-star"></i></small>': '' ; ?> </div> </a></td>
                                                            <td><span><?php echo $property->area; ?></span></td>
                                                            <td><span><?php echo $property->bed; ?></span></td>
                                                            <td><span><?php echo $property->bath; ?></span></td>
                                                            <td><span><?php echo number_format($property->price, 2, '.', ',');?></span></td>
                                                            <td><span><?php echo $property->no_years; ?></span></td>
                                                            <td><span>Pending</span></td>
                                                            <td><span>Today</span></td>
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
		<script src="js/lib/morris-chart/morris.js"></script>
        <script src="js/lib/datatables/datatables.min.js"></script>
        <script src="js/lib/datatables/datatables-init.js"></script>
	';
?>

<?php include("includes/footer.php"); ?>