<?php require_once('../../private/initialize.php'); ?>
<?php require_login();
if(SystemUsers::is_reesa()) {
    $role = 'reesa';
}else if(SystemUsers::is_lister()) {
    $role = 'lister';
    $person = 'lister_id';
}else if(SystemUsers::is_user()) {
    $pnd_link = 'sort';
    $role = 'user';
    $person = 'user_id';
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
                    <h3 class="text-primary">Completed purchase</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Completed purchase</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                
                <?php

                    // $properties = Property::find_all_current_lister();
                    // foreach ($properties as $property) {


                    $prpt_ongoin_objs = PropertyTransDetails::completed_trans($person);
                    foreach ($prpt_ongoin_objs as $prpt_ongoin_obj) {
                        $ongoin_offers = Property::find_all_by_id($prpt_ongoin_obj->property_id, 0, '');
                        foreach($ongoin_offers as $property) {


                ?>
                            <div class="row bg-white m-b-8 dshLstWrpRw" style="height: 220px;">
                                <div class="col-md-3 p-l-0 dshLstImgWp">
                                    <img style="height: 100%;" src='../backend/images/lister/<?php if($property->display != ''){echo $property->id.'/'.$property->display;}else{echo 'placeholder.png';}?>'>
                                </div>
                                <div class="col-md-6 DshlstFts">
                                    <h3 class="m-b-0 m-t-4"><?php echo $property->address; ?></h3>
                                    <p><i class="fa fa-map-marker"></i> <?php echo ucfirst($property->state); ?></p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="m-b-0">Area</h5><span><?php echo $property->area; ?></span>
                                            <h5 class="m-b-0 m-t-10">Bathrooms</h5><span><?php echo $property->bath; ?></span>
                                            <h5 class="m-b-0 m-t-10">Type</h5><span>Apartment</span>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="m-b-0">Bedroom</h5><span><?php echo $property->bed; ?></span>
                                            <h5 class="m-b-0 m-t-10">Classification</h5><span>Standard</span>
                                            <h5 class="m-b-0 m-t-10">Status</h5><span>For Sale</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3 m-t-10">
                                    <?php 
                                        if($property->no_years > 0) {
                                            $monthly_price = $property->price / ($property->no_years * 12) ;
                                        }else {
                                            $monthly_price = 0;
                                        }
                                    ?> 
                                    <h3 class="m-b-0"><small>Paid: </small>N<?php echo number_format($property->price, 2, '.', ','); ?></h3>
                                    <p><?php echo 'N'. number_format($monthly_price, 2, '.', ','); ?> Monthly for <?php echo $property->no_years;?> years</p>
                                    <div class="row">
                                        <div class="card m-t-0 p-b-0 m-b-0" style="border-radius: 0">
                                            <span class="label label-rouded label-primary"><i class="fa fa-check m-r-5"></i>Status: Completed</span>
                                            <br>
                                            Date Completed: Today
                                        </div>
                                    </div>
                                        <div class="row m-t-20">
                                            <div class="col-md-5">
                                                <a class="text-primary" href="#">View History</a>
                                            </div>
                                            <div class="col-md-7">
                                                <a href="invoice.php">Generate Receipt</a>
                                            </div>
                                        </div>

                                </div>
                            </div>

                <?php
                        }
                    }
                ?>

                <!-- End Page Content -->
            </div>            
        </div>

        <!-- End Page wrapper  -->


<?php include("includes/footer.php"); ?>