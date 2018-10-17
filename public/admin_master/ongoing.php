<?php require_once('../../private/initialize.php'); ?>
<?php require_login();?>
<?php
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

if(isset($_GET['ysp'])) {
    $propt_id = $_GET['ysp'];

    $property_obj = Property::find_by_id($propt_id);
    if($property_obj === false) { redirect_to('index.php'); }
    //is_user, is listers property
    //cannot pay/recieve offer twice on the same listing and user
}
?>
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
        <div class="page-wrapper dshWrp">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Ongoing Listings</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Ongoing Listings</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

                <!-- Start Page Content -->
                
                <!-- Container fluid  -->
                <?php
                if(!isset($propt_id)) {
                    
                    $prpt_ongoin_objs = PropertyTransDetails::ongoin_offers($person);
                    foreach ($prpt_ongoin_objs as $prpt_ongoin_obj) {
                        $ongoin_offers = Property::find_all_by_id($prpt_ongoin_obj->property_id, 0, '');
                        foreach($ongoin_offers as $offers) {
                ?>

                        <div class="container-fluid">
                            <a href="?ysp=<?php echo $offers->id;?>&eup=rsano3/listing/gs_l=16d">
                            <div style="height: 120px" class="row bg-white">
                                <div class="col-md-3 p-l-0" style="overflow: hidden;">
                                    <img src='../backend/images/lister/<?php if($offers->display != ''){echo $offers->id.'/'.$offers->display;}else{echo 'placeholder.png';}?>'>
                                </div>
                                <div class="col-md-6 p-t-10">
                                    <h4 class="m-b-4"><?php echo $offers->address;?></h4>
                                    <p class="m-t-2"><i class="fa fa-map-marker m-r-5"></i><?php echo ucfirst($offers->state);?></p>
                                    <p><span class="m-r-15"><i class="fa fa-bed m-r-5"></i><?php echo $offers->bed;?></span> <span class="m-r-15"><i class="fa fa-bath m-r-5"></i><?php echo $offers->bath;?></span> <span class="m-r-15"><i class="fa fa-crop m-r-5"></i><?php echo $offers->area;?></span> <span class="m-r-15"><i class="fa fa-tag m-r-5"></i>For Rent</span></p>
                                </div>
                                <div class="col-md-3 p-t-10">
                                    <h3 class="m-b-0">N<?php echo number_format($offers->price, 2, '.', ',');?></h3>
                                    <?php 
                                        if($offers->no_years > 0) {
                                            $monthly_price = $offers->price / ($offers->no_years * 12) ;
                                        }else {
                                            $monthly_price = 0;
                                        }
                                    ?>  
                                    <p><?php echo 'N'. number_format($monthly_price, 2, '.', ',') .' For '.$offers->no_years;?> years</p>
                                    <div>
                                        <span class="btn btn-success btn-rounded m-b-10 m-l-5">View Summary</span> 
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    
                <?php
                        }
                        //pr($trans_offers);
                        # code...
                    }
 

                }
                ?>

                <?php
                    if(isset($propt_id)) {
                ?>

                        <div class="container-fluid">
                            <div style="height: 120px" class="row bg-white">
                                <div class="col-md-3 p-l-0" style="overflow: hidden;">
                                    <img src='../backend/images/lister/<?php if($property_obj->display != ''){echo $property_obj->id.'/'.$property_obj->display;}else{echo 'placeholder.png';}?>'>
                                </div>
                                <div class="col-md-6 p-t-10">
                                    <h4 class="m-b-4"><?php echo $property_obj->address;?></h4>
                                    <p class="m-t-2"><i class="fa fa-map-marker m-r-5"></i><?php echo $property_obj->state;?></p>
                                    <p><span class="m-r-15"><i class="fa fa-bed m-r-5"></i><?php echo $property_obj->bed;?></span> <span class="m-r-15"><i class="fa fa-bath m-r-5"></i><?php echo $property_obj->bath;?></span> <span class="m-r-15"><i class="fa fa-crop m-r-5"></i><?php echo $property_obj->area;?></span> <span class="m-r-15"><i class="fa fa-tag m-r-5"></i>For Rent</span></p>
                                </div>
                                <div class="col-md-3 p-t-10">
                                    <h3><?php echo $property_obj->price;?></h3>
                                    <p>N50,000/month for <?php echo $property_obj->no_years;?> years</p>
                                    
                                </div>
                            </div>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="card bg-transparent p-0">
                                            <img style="width:100%; border-radius:10%" src="">                                
                                        </div>
                                    </div>
                                    <div div class="col-md-5">
                                        <div class="row padding p-t-10">
                                            <div class="col-md-12 p-10">
                                                Full Name: X
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 p-10">
                                                Email: Y
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 p-10">
                                                Address: Z
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 p-10">
                                                Phone: 0
                                            </div>
                                        </div>
                                    </div>
                                    <div div class="col-md-4 p-10">
                                        <div class="row p-10">
                                            <a class="btn btn-dark btn-outline btn-rounded btn-sm" href="#">Message</a>
                                        </div>
                                        <div class="row p-10">
                                                 
                                        </div>
                                    </div>
                                </div>                 
                            </div>

                        </div>                    

                <?php
                    }
                ?>

                <!-- End Page Content -->

        </div>

        <!-- End Page wrapper  -->


<?php include("includes/footer.php"); ?>