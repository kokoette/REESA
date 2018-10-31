<?php require_once('../../private/initialize.php'); ?>
<?php require_login();?>
<?php lister();?>
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
                    <h3 class="text-primary">My Listings</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">My Listings</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                
                <?php 
                    $properties = Property::find_all_current_lister();
                    foreach ($properties as $property) {
                        $propty_img = Property::get_property_images($property->id);
                ?>
                <div class="row bg-white m-b-8 dshLstWrpRw" style="">
                    <div class="col-lg-3 p-l-0 dshLstImgWp">
                        <img style="" src='../backend/images/lister/<?php if($property->display != ''){echo $property->id.'/'.$property->display;}else{echo 'placeholder.png';}?>'>
                    </div>
                    <div class="col-lg-6 DshlstFts">
                        <a href="../front_templated/view.php?liebe=<?php echo $property->id; ?>&eup=rsano3/listing/gs_l=16_erwidern_dreal+soluop=thisell/p350">
                            <h3 class="m-b-1 m-t-10" >
                                <?php echo $property->title; ?>
                            </h3>
                        </a>
                        <p><i class="fa fa-map-marker"></i> <?php echo $property->address. ', ' .$property->state; ?></p>
                        <div class="row dshLstFtsRw m-t-32">
                            <div class="col-sm-4">

                                            <div class="b">
                                                <div><i class="fa fa-crop e"></i></div>
                                                <div class="f"> <?php echo $property->area; ?></div>             
                                            </div>
                                            <div class="b">
                                                <div><i class="fa fa-bath e"></i></div>
                                                <div class="f"> <?php echo $property->bath; ?></div>
                                            </div>
                                            <div class="b">
                                                <div><i class="fa fa-home e"></i></div>
                                                <div class="f"> Apartment </div>
                                            </div>
                            </div>
                            <div class="col-sm-4">
                                            <div class="b">
                                                <div><i class="fa fa-bed e"></i></div>
                                                <div class="f"> <?php echo $property->bed; ?></div>             
                                            </div>
                                            <div class="b">
                                                <div><i class="fa fa-language e"></i></div>
                                                <div class="f">Classification: Standard</div>
                                            </div>
                                            <div class="b">
                                                <div><i class="fa fa-tag e"></i></div>
                                                <div class="f"> <?php echo $property->sale_rent; ?> </div>
                                            </div>
                            </div>
                            <div class="col-sm-4">
                                            <div class="b">
                                                <!-- <div><i class="fa fa-bed e"></i></div> -->
                                                <div class="f">Ref No.:</div>             
                                            </div>
                                            <div class="b">
                                                <!-- <div><i class="fa fa-language e"></i></div> -->
                                                <div class="f">Status: <b>Published</b></div>
                                            </div>
                                            <div class="b">
                                                <!-- <div><i class="fa fa-tag e"></i></div> -->
                                                <div class="f m-t-10"> <a class="text-primary" href="../front_templated/view.php?liebe=<?php echo $property->id; ?>&eup=rsano3/listing/gs_l=16_erwidern_dreal+soluop=thisell/p350">View on front end</a> </div>
                                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 lstDscp">
                        <h4 class="m-b-0 m-t-9">Description</h4>
                        <p class="m-b-20"><?php echo $property->description; ?> ...</p>
                        <h3 class="m-b-0">N<?php echo number_format($property->price, 2, '.', ','); ?></h3>

                        <?php 
                        if($property->no_years > 0) {
                            $monthly_price = $property->price / ($property->no_years * 12) ;
                        }else {
                            $monthly_price = 0;
                        }
                        ?>
                        <p class="m-b-0">N<?php echo number_format($monthly_price, 2, '.', ','); ?> monthly for <?php echo $property->no_years; ?> years</p>
                        <div class="row">
                            <div class="card m-t-0 p-b-0 m-b-0 lstEdtBtn" style="border-radius: 0">
                                <a class="btn btn-default btn-rounded" href="edit_property.php?psy=<?php echo $property->id;?>&eup=rsano3/listing/gs_l=16d"><i class="fa fa-edit"></i> Edit</a>
                            </div>
                            <div class="card m-t-5 p-b-0 m-b-0 lstdltBtn" style="border-radius: 0">
                                <a class="btn btn-danger btn-flat btn-addon btn-xs m-b-10" href="../../private/delete_listing.php?loschen=<?php echo $property->id; ?>&eup=rsano3/listing/gs_l=16_erwidern"><i class="fa fa-close"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    }
                ?>

                <!-- End Page Content -->
            </div>            


        </div>

        <!-- End Page wrapper  -->

<?php
$footer_cust_lib = '
';
?>
<?php include("includes/footer.php"); ?>