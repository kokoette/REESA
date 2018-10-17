<?php require_once('../../private/initialize.php'); 

require_login();
//reesa();

if(isset($_GET['set'])) {
    $get_ft = $_GET['featured'];
    foreach ($get_ft as $key => $value) {
        if($value != '' && is_numeric($value)) {
            Property::set_featured($key, $value);
        }
    }
    $session->message('Featured Property order Updated Successfully');
    redirect_to('set_featured.php');
}

if(isset($_GET['add_featured'])) {
    $add_featured = $_GET['add_featured'];
    Property::set_featured($add_featured, 1);

    $session->message('Property Successfully added to Featured');
    redirect_to('set_featured.php');
}

if(isset($_GET['unset_featured'])) {
    $unset_featured = $_GET['unset_featured'];
    Property::set_featured($unset_featured, 0);

    $session->message('Property Successfully removed from Featured');
    redirect_to('set_featured.php');
}


$page_title = "Reesa.com My Dashboard";
$custom_css_library = '
	<link href="css/lib/bootstrap/bootstrap-extend.min.css" rel="stylesheet">
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
                    <h3 class="text-primary"><a class="m-r-10 bckEdtImgs" href="all_listings.php"><i class="fa fa-reply"></i><a>Set featured Listings</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="all_listings.php">All Listings</a></li>
                        <li class="breadcrumb-item active">Set featured Listings</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

                <!-- Start Page Content -->
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <?php
                                    $ft_propties = Property::find_featured();
                                    if(count($ft_propties) < 6) {
                            ?>
                            <div class="m-t-12"><a href="?addmore=true" class="btn btn-dark btn-outline btn-rounded">Add More <i class="fa fa-plus"></i> </a></div>
                            <?php
                                    }
                            ?>

                            <?php
                                if(isset($_GET['addmore'])) {
                            ?>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="card">
                                            <h4>Select Listing to feature</h4>
                                            <table id="myTable" class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Address</th>
                                                        <th>Area</th>
                                                        <th>Price</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $not_ftds = Property::find_not_featured();
                                                        foreach ($not_ftds as $not_ftd) {
                                                    ?>

                                                        <tr>
                                                            <td>
                                                                <div class="rect-img">
                                                                    <img src='../backend/images/lister/<?php if($not_ftd->display != ''){echo $not_ftd->id.'/'.$not_ftd->display;}else{echo 'placeholder.png';}?>' alt=""></a>
                                                                </div>
                                                            </td>
                                                            <td class="p-0"><a style="padding: 0.55rem;display: block;" href="?add_featured=<?php echo $not_ftd->id; ?>"><?php echo $not_ftd->address; ?></a></td>
                                                            <td><?php echo $not_ftd->area; ?></td>
                                                            <td><?php echo number_format($not_ftd->price, 2, '.', ','); ?></td>
                                                            <td>Date</td>
                                                        </tr>

                                                    <?php
                                                        }
                                                    ?>
                                                        
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>

                            <form action="" method="get">
                                <div class="row">
                                    <?php
                                        foreach ($ft_propties as $ft_property) {
                                    ?>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div style="position: relative;">
                                                    <a style="position: absolute;right: 0;background-color: #ccc;padding: 5px 9px 3px 8px;border-radius: 50%;box-shadow: 0px 0px 1px 1px rgb(220, 157, 157);" href="?unset_featured=<?php echo escape($ft_property->id); ?>"> <i class="fa fa-minus"></i></a>
                                                    <img width="100%" src='../backend/images/lister/<?php if($ft_property->display != ''){echo $ft_property->id.'/'.$ft_property->display;}else{echo 'placeholder.png';}?>'> 
                                                </div>
                                                <br>
                                                <div><?php echo $ft_property->address; ?></div>
                                                <div><i class="fa fa-bed"> <?php echo $ft_property->bed; ?> </i> &nbsp; <i class="fa fa-bath"> <?php echo $ft_property->bath; ?> &nbsp;</i> N<?php echo number_format($ft_property->price, 2, '.', ',');?></div>
                                                <div class="m-t-10">
                                                    <small><i>order</i></small>
                                                    <input style="width: 60px; display: inline-block;" class="form-control input-default" type="number" value="<?php echo escape($ft_property->featured); ?>" required name="featured[<?php echo escape($ft_property->id); ?>]" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }                               
                                    ?>
                                </div>
                                <div>
                                    <?php
                                    if(!isset($_GET['addmore'])) {
                                    ?>
                                    <input type="submit" class="btn btn-info p-l-30 p-r-30" value="Update" name="set">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </form>
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