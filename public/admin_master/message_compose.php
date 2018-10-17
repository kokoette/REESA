<?php require_once('../../private/initialize.php'); 

require_login();

if(isset($_GET['psy'])) {
    $snd_get_prp = $_GET['psy'];
    $snd_prp = Property::real_find_id($snd_get_prp);
    if($snd_prp === false) {
        redirect_to('../design_system/index.php');
    }
    $snPrsnObj = SystemUsers::find_by_id($snd_prp->lister_id);
}

if(isset($_GET['gngnm'])) {
    if(isset($_GET['verste_sd'])) {
        $pnd_prop = $_GET['gngnm'];
        $pnd_sndr = $_GET['verste_sd'];
        $pnd_snd_prp = Property::real_find_id($pnd_prop);
        if($pnd_snd_prp === false) {
            redirect_to('../design_system/index.php');
        }
        $ofrPnObj = SystemUsers::find_by_id($pnd_sndr);
    } else {
        redirect_to('../design_system/index.php');        
    }

}



//$sndwthpropt = $_GET['psy'];

if(is_post_request()) {
    $args = [];

    $args['sender_id'] = $_SESSION['sys_user_id'];
    $args['receiver_id'] = $_POST['receiver_id'] ?? NULL;
    $args['property_id'] = $_POST['property_id'] ?? NULL;
    $args['subject'] = $_POST['subject'] ?? NULL;
    $args['message'] = $_POST['message'] ?? NULL;

    $args['sender_view'] = 0;
    $args['receiver_view'] = 0;

    $args['sender_delete'] = 0;
    $args['receiver_delete'] = 0;

    $args['date_time'] = 12072018;

    $send_msg = new Message($args);
    $result = $send_msg->create();

    if($result) {
        $session->message('Your message has been sent');
        redirect_to('message_inbox.php?sent_mail=true');        
    }

} else {
    $send_msg = new Message;    
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
            <div class="row page-titles m-b-4">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Compose</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Compose</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        
                        <?php echo display_errors($send_msg->errors); ?>

                        <div class="card">
                            <div class="card-body">
                                <div class="card-content">
                                    <!-- Left sidebar -->
                                    <div class="inbox-leftbar">

                                        <a href="message_inbox.php" class="btn btn-danger btn-block waves-effect waves-light">Inbox</a>

                                        <div class="mail-list mt-4">
                                            <a href="message_inbox.php" class="list-group-item border-0 text-danger"><i class="mdi mdi-inbox font-18 align-middle mr-2"></i><b>Inbox</b><span class="label label-danger float-right ml-2"><?php echo $unrd_msg_cnt; ?></span></a>
                                            <a href="#" class="list-group-item border-0"><i class="mdi mdi-file-document-box font-18 align-middle mr-2"></i>Draft<span class="label label-info float-right ml-2">0</span></a>
                                            <a href="message_inbox.php?sent_mail=true" class="list-group-item border-0"><i class="mdi mdi-send font-18 align-middle mr-2"></i>Sent Mail</a>
                                        </div>
                                    </div>
                                    <!-- End Left sidebar -->
                                    <div class="inbox-rightbar">
                                        <div class="mt-4">
                                            <form role="form" action="" method="post">
                                                <div class="form-group">
                                                    <select name="receiver_id" class="form-control input-default">
                                                            <?php
                                                            if(isset($snd_get_prp)) {
                                                                echo '<option value='. $snPrsnObj->id .'>'. $snPrsnObj->full_name .'</option>';
                                                            } elseif (isset($pnd_prop, $pnd_sndr)) {
                                                                echo '<option value='. $ofrPnObj->id .'>'. $ofrPnObj->full_name .'</option>';
                                                            } else {
                                                                echo '<option value="">Select Person</option>';
                                                                if(SystemUsers::is_lister()) {
                                                                    $person = 'user';
                                                                    $to_indx = 'user_id';
                                                                }elseif(SystemUsers::is_user()) {
                                                                    $person = 'lister';
                                                                    $to_indx = 'lister_id';
                                                                }
                                                                if(SystemUsers::is_reesa()) {
                                                                    SystemUsers::find_row_all(); 
                                                                } else {
                                                                    $to_result_id = Property::person_trans_with($person);
                                                                    while ($to_row_id = $to_result_id->fetch_assoc()) {

                                                                        $nw_to = $to_row_id[$to_indx];
                                                                        $new_to_obj = SystemUsers::find_by_id($nw_to);
                                                                        echo '<option value='. $new_to_obj->id .'>'. $new_to_obj->full_name .'</option>';
                                                                    }
                                                                }
                                                            }
                                                            ?>

                                                        </select>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" name="subject" class="form-control input-default" placeholder="Subject">
                                                </div>
                                                <div class="form-group">
                                                    <textarea name="message" placeholder="Message" rows="8" cols="80" class="form-control input-default" style="height:300px"></textarea>
                                                </div>



                                                <?php
                                                    if(isset($snd_get_prp) || isset($pnd_prop)) {
                                                        if(isset($snd_get_prp)) {
                                                            $alt_prp_obj = $snd_prp;
                                                        } elseif(isset($pnd_prop)) {
                                                            $alt_prp_obj = $pnd_snd_prp;
                                                        }
                                                ?>
                                                        <hr/>
                                                        <div class="container-fluid">
                                                            <h6> <i class="fa fa-paperclip mb-2"></i> Attachments <span>(1)</span> </h6>

                                                            <div style="height: 120px" class="row bg-white">
                                                                <div class="col-md-3 p-l-0" style="overflow: hidden;">
                                                                    <img src='../backend/images/lister/<?php if($alt_prp_obj->display != ''){echo $alt_prp_obj->id.'/'.$alt_prp_obj->display;}else{echo 'placeholder.png';}?>'>
                                                                </div>
                                                                <div class="col-md-6 p-t-10">
                                                                    <h4 class="m-b-4"><?php echo $alt_prp_obj->address;?></h4>
                                                                    <p class="m-t-2"><i class="fa fa-map-marker m-r-5"></i><?php echo $alt_prp_obj->state;?></p>
                                                                    <p><span class="m-r-15"><i class="fa fa-bed m-r-5"></i><?php echo $alt_prp_obj->bed;?></span> <span class="m-r-15"><i class="fa fa-bath m-r-5"></i><?php echo $alt_prp_obj->bath;?></span> <span class="m-r-15"><i class="fa fa-crop m-r-5"></i><?php echo $alt_prp_obj->area;?></span> <span class="m-r-15"><i class="fa fa-tag m-r-5"></i>For Rent</span></p>
                                                                </div>
                                                                <div class="col-md-3 p-t-10">
                                                                    <?php 
                                                                        if($alt_prp_obj->no_years > 0) {
                                                                            $monthly_price = $alt_prp_obj->price / ($alt_prp_obj->no_years * 12) ;
                                                                        }else {
                                                                            $monthly_price = 0;
                                                                        }
                                                                    ?> 
                                                                    <h3><?php echo number_format($alt_prp_obj->price, 2, '.', ',');?></h3>
                                                                    <p><?php echo 'N'. number_format($monthly_price, 2, '.', ',') .' For '.$alt_prp_obj->no_years;?> years</p>
                                                                </div>
                                                                <input type="hidden" name="property_id" value="<?php echo $alt_prp_obj->id;?>">
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                ?>

                                                <div class="form-group m-b-0">
                                                    <div class="text-right">
                                                        <button type="submit" class="btn btn-success"> <span>Send</span> <i class="fa fa-send m-l-10"></i> </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        <!-- end card-->
                                    </div>
                                </div>
                            </div>
                        </div>
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



        <!-- End Page wrapper  -->
<?php include("includes/footer.php"); ?>