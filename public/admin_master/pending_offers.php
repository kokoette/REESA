<?php require_once('../../private/initialize.php');
///////--for user and reesa------------////////////////////////-reminder--------$pnd_link = 'link_front_end_single_list';
require_login();

//-----for require login if role is not 1,2,3----no login
//----if not reesa, user or lister-redirect;
if(SystemUsers::is_reesa()) {
    $role = 'reesa';
}else if(SystemUsers::is_lister()) {
    $role = 'lister';
}else if(SystemUsers::is_user()) {
    $pnd_link = 'sort';
    $role = 'user';
}

Property::delete_request_noti();

if(isset($_GET['ysp'])) {

    //lister();
    if(!SystemUsers::is_reesa() && !SystemUsers::is_lister()) {
        redirect_to('../design_system/login.php');
    }

    $propt_id = $_GET['ysp'];
    $property_obj = Property::find_by_id($propt_id);
    if($property_obj === false) { redirect_to('index.php'); }
    //is_user, is listers property
    //cannot pay/recieve offer twice on the same listing and user

    if(isset($_GET['accept'])) {
        $user_id =  $_GET['accept'];
        $property_id = $propt_id;
        $lister_id = $_SESSION['sys_user_id'];
        $start_property_price = $property_balance = $property_obj->price;
        //$propert_balance = $property_obj->price;
        $start_total_months = $months_left = (int)$property_obj->no_years * 12;
        //$months_left = (int)$property_obj->no_years * 12;
        $deduct_monthly = $property_obj->price / $start_total_months;
        $total_months_paid = 0;
        $total_paid_amount = 0;
        $completed = false;

        if(Property::is_ongin_compt($property_id)) {
            $session->message('Error- Property already in transaction');
            redirect_to('index.php');
        }

        $sql = "INSERT INTO propty_trans_details (user_id, property_id, lister_id, start_property_price, property_balance, start_total_months, months_left, deduct_monthly, total_months_paid, total_paid_amount, completed) VALUES ('$user_id', '$property_id', '$lister_id', '$start_property_price', '$property_balance', '$start_total_months', '$months_left', '$deduct_monthly', '$total_months_paid', '$total_paid_amount', '$completed') ";

        $result = $database->query($sql);
        if($result) {
            // {"admin": 1}
            //$prop_status = '{"ongoing": 1}';
            $prop_status = '{"ongoing": 1}';
            $sql2 = "UPDATE properties SET offer = '', status = '". $prop_status ."' WHERE id = '". $property_id ."' LIMIT 1";
            $result2 = $database->query($sql2);
            if ($result2) {
                $session->message('Property sold payment will begin shortly');
                redirect_to('ongoing.php');
            } else {
                echo 'Error with offer';
            }
        } else {
            echo "Error accepting offer";
        }

        
    }
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
            <div class="row page-titles m-b-14">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary"> <?php echo (isset($propt_id)) ? '<a class="m-r-10 bckEdtImgs" href="pending_offers.php"><i class="fa fa-reply"></i><a>':'' ; echo ($role == 'user') ? 'Pending sent':'Pending received' ?> offers</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Pending offers</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

                <!-- Start Page Content -->
                
                <!-- Container fluid  -->
                    <?php
                if(!isset($propt_id)) {

                    if($role == 'reesa') {

                    }elseif($role == 'lister') {
                        $crnt_listr_ofr_obj = Property::curnt_listr_offers();
                        foreach ($crnt_listr_ofr_obj as $offers) {
                                $ofr_array = $offers->offer;
                                $ofr_users = explode(", ", $ofr_array);
                                $no_ofrs = count(array_unique($ofr_users));
                    ?>
                            <div class="container-fluid">
                                <?php
                                    if($role == 'user') {
                                        $pnd_link = 'link_front_end_single_list';
                                    }else if($role == 'lister') {
                                        $pnd_link = '?ysp='.$offers->id.'&eup=rsano3/listing/gs_l=16d';
                                    }else if($role == 'lister') {
                                        $pnd_link = 'sort';
                                    }
                                ?>
                                <a href="<?php echo $pnd_link; ?>">
                                <div style="height: 120px" class="row bg-white">
                                    <div class="col-md-3 p-l-0" style="overflow: hidden;">
                                        <img src='../backend/images/lister/<?php if($offers->display != ''){echo $offers->id.'/'.$offers->display;}else{echo 'placeholder.png';}?>'>
                                    </div>
                                    <div class="col-md-6 p-t-10">
                                        <h4 class="m-b-4"><?php echo $offers->address;?></h4>
                                        <p class="m-t-2"><i class="fa fa-map-marker m-r-5"></i><?php echo $offers->state;?></p>
                                        <p><span class="m-r-15"><i class="fa fa-bed m-r-5"></i><?php echo $offers->bed;?></span> <span class="m-r-15"><i class="fa fa-bath m-r-5"></i><?php echo $offers->bath;?></span> <span class="m-r-15"><i class="fa fa-crop m-r-5"></i><?php echo $offers->area;?></span> <span class="m-r-15"><i class="fa fa-tag m-r-5"></i>For Rent</span></p>
                                    </div>
                                    <div class="col-md-3 p-t-10">
                                        <?php 
                                            if($offers->no_years > 0) {
                                                $monthly_price = $offers->price / ($offers->no_years * 12) ;
                                            }else {
                                                $monthly_price = 0;
                                            }
                                        ?> 
                                        <h3><?php echo number_format($offers->price, 2, '.', ',');?></h3>
                                        <p><?php echo 'N'. number_format($monthly_price, 2, '.', ',') .' For '.$offers->no_years;?> years</p>
                                    </div>
                                </div>
                                <div class="row vwPndOfr">
                                    <i class="fa fa-level-down"></i> View pending offers <span style="" class="badge badge-warning"><?php echo $no_ofrs;?></span>
                                </div>
                                <div style="clear: both;"></div>
                                </a>
                            </div>
                    <?php
                        }
                    } elseif($role == 'user') {
                        $usr_propt_ofrs = Property::prpty_offers_frm_usrs();
                        foreach ($usr_propt_ofrs as $offers) {
                            $usr_ofr_ary = explode(',', $offers->offer);
                            if(in_array($_SESSION['sys_user_id'], $usr_ofr_ary)) {
                    ?>
                            <div class="container-fluid">
                                <a href="link_front_end_single_list">
                                <div style="height: 120px" class="row bg-white">
                                    <div class="col-md-3 p-l-0" style="overflow: hidden;">
                                        <img src='../backend/images/lister/<?php if($offers->display != ''){echo $offers->id.'/'.$offers->display;}else{echo 'placeholder.png';}?>'>
                                    </div>
                                    <div class="col-md-6 p-t-10">
                                        <h4 class="m-b-4"><?php echo $offers->address;?></h4>
                                        <p class="m-t-2"><i class="fa fa-map-marker m-r-5"></i><?php echo $offers->state;?></p>
                                        <p><span class="m-r-15"><i class="fa fa-bed m-r-5"></i><?php echo $offers->bed;?></span> <span class="m-r-15"><i class="fa fa-bath m-r-5"></i><?php echo $offers->bath;?></span> <span class="m-r-15"><i class="fa fa-crop m-r-5"></i><?php echo $offers->area;?></span> <span class="m-r-15"><i class="fa fa-tag m-r-5"></i>For Rent</span></p>
                                    </div>
                                    <div class="col-md-3 p-t-10">
                                        <?php 
                                            if($offers->no_years > 0) {
                                                $monthly_price = $offers->price / ($offers->no_years * 12) ;
                                            }else {
                                                $monthly_price = 0;
                                            }
                                        ?> 
                                        <h3><?php echo number_format($offers->price, 2, '.', ',');?></h3>
                                        <p>N<?php echo number_format($monthly_price, 2, '.', ','); ?>/month for <?php echo $offers->no_years;?> years</p>
                                    </div>
                                </div>
                                </a>
                            </div>
                        <?php
                            }
                        }
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
                                        <?php 
                                            if($property_obj->no_years > 0) {
                                                $month_price = $property_obj->price / ($property_obj->no_years * 12) ;
                                            }else {
                                                $month_price = 0;
                                            }
                                        ?>                                    
                                    <h3><?php echo number_format($property_obj->price, 2, '.', ',');?></h3>
                                    <p>N<?php echo number_format($month_price, 2, '.', ',') ?>/month for <?php echo $property_obj->no_years;?> years</p>
                                </div>
                            </div>

                            <?php
                                $pro_array = $property_obj->offer;
                                $req_users = explode(", ", $pro_array);
                                $req_users = array_unique($req_users);
                                foreach ($req_users as $req_user) {
                                    //pr($req_users);
                                    $user = SystemUsers::find_by_id($req_user);
                                    if($user !== false) {
                                    
                            ?>


                                        <div class="container">
                                            <div class="row justify-content-center">
                                                <div class="col-md-8">
                                                    <div class="card pnOfUCrd">
                                                        <div class="pnOfUWrp">

                                                            <div class="pOUTop">
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <div class="pOUTImg">
                                                                            <?php if($user->profile != '') { echo '<img src="../backend/images/profile/'.$user->profile.'" class="img-fluid">'; } else {echo '<i class="fa fa-user-circle-o"></i>';} ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <div class="pOUTInfo">
                                                                            <p>Date Sent:</p>
                                                                            <h2>Full: <?php echo $user->full_name; ?></h2>
                                                                            <span>Email: <?php echo $user->email; ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="pOUBtm">
                                                                <hr />
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div>
                                                                            <h5>Address: <?php echo $user->address; ?></h5>
                                                                        </div> 
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div>
                                                                            <p>Phone: <?php echo $user->phone; ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="pnOfUAct">
                                                            <div class="row">    
                                                                <div class="col-md-4 pOUAcpt">
                                                                    <a href="?accept=<?php echo $user->id; ?>&ysp=<?php echo $property_obj->id; ?>&eup=rsano3/listing/gs_l=16d">
                                                                        <i class="fa fa-handshake-o"></i>
                                                                        <p>Accept</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-4 pOUMsg">
                                                                    <a href="../admin_master/message_compose.php?gngnm=<?php echo $property_obj->id; ?>&verste_sd=<?php echo $user->id; ?>&erit2206/&=fbisale_undvohi/sol=ti&ibi!=ne">
                                                                        <i class="fa fa-comments-o"></i>
                                                                        <p>Message</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-4 pOURjt">
                                                                    <a href="">
                                                                        <i class="fa fa-remove"></i>
                                                                        <p>Reject</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    

                            <?php
                                    }else {
                                        echo "Something went wrong: Could not retrieve the user details please contact Reesa";
                                    }
                                }
                            ?>

                        </div>                    

                <?php
                    }
                ?>

                <!-- End Page Content -->

        </div>

        <!-- End Page wrapper  -->


<?php include("includes/footer.php"); ?>