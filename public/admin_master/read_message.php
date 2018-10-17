<?php require_once('../../private/initialize.php'); 

require_login();

if(isset($_GET['loschen'])) {
    $delt_id = $_GET['loschen'];
    $dl_prs_id = 'receiver_id';
    $prsn_deltd = 'sender_delete';
    $get_suffix = '';
    $person = 'receiver_delete';
    if(isset($_GET['read_sent'])) {
        $dl_prs_id = 'sender_id';
        $get_suffix = '?sent_mail=true';
        $prsn_deltd = 'receiver_delete';
        $person = 'sender_delete';
    }
    $delte_obj = Message::find_by_id($delt_id);

    if($delte_obj->$dl_prs_id) {
        if(!$delte_obj->$prsn_deltd == 0) {
            $delte_obj->delete();
        }else {
            $delte_obj->set_delete($person);
        }
        $session->message("Message deleted");
        redirect_to('message_inbox.php'.$get_suffix);        

        // die($dl_prs_id);
        // exit();
    }else {
        $session->message('Error: Could not delete message');
        redirect_to('message_inbox.php');        
    }
}

if(!isset($_GET['sprech'])) {
    redirect_to('index.php');
}
$msg_id = $_GET['sprech'];


if(!Message::is_my_message($msg_id)) {
    redirect_to('index.php');
}


if(isset($_GET['read_sent'])) {
    $my_msg = Message::get_message_by_id($msg_id, 'receiver_id');
    $delete_link = '?read_sent=wahr&loschen=' . $my_msg->id . '&gs_l=16d&bots=12_4tqy';
}else {
    $my_msg = Message::get_message_by_id($msg_id, 'sender_id');
    $delete_link = '?loschen=' . $my_msg->id . '&gs_l=16d&bots=12_4tqy';
}
if($my_msg == false) {
    redirect_to('index.php');    
}

$my_msg->set_read('receiver');

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
                    <h3 class="text-primary">Inbox</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Inbox</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-content">
                                    <!-- Left sidebar -->
                                    <div class="inbox-leftbar">

                                        <a href="message_compose.php" class="btn btn-danger btn-block waves-effect waves-light">Compose</a>

                                        <div class="mail-list mt-4">
                                            <a href="message_inbox.php" class="list-group-item border-0 text-danger"><i class="mdi mdi-inbox font-18 align-middle mr-2"></i><b>Inbox</b><span class="label label-danger float-right ml-2"><?php echo $unrd_msg_cnt;?></span></a>
                                            <a href="#" class="list-group-item border-0"><i class="mdi mdi-file-document-box font-18 align-middle mr-2"></i>Draft<span class="label label-info float-right ml-2">0</span></a>
                                            <a href="message_inbox.php?sent_mail=true" class="list-group-item border-0"><i class="mdi mdi-send font-18 align-middle mr-2"></i>Sent Mail</a>
                                        </div>
                                    </div>
                                    <!-- End Left sidebar -->
                                    <div class="inbox-rightbar">

                                        <div class="m-t-10 m-b-20" role="toolbar">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light waves-effect"><i class="mdi mdi-archive font-18 vertical-middle"></i></button>
                                                <button type="button" class="btn btn-light waves-effect"><i class="mdi mdi-alert-octagon font-18 vertical-middle"></i></button>
                                                <button type="button" class="btn btn-light waves-effect"><i class="mdi mdi-delete-variant font-18 vertical-middle"></i></button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-folder font-18 vertical-middle"></i>
                                                                                    <b class="caret m-l-5"></b>
                                                                                </button>
                                                <div class="dropdown-menu">
                                                    <span class="dropdown-header">Move to</span>
                                                    <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                                </div>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="mdi mdi-label font-18 vertical-middle"></i>
                                                                                    <b class="caret m-l-5"></b>
                                                                                </button>
                                                <div class="dropdown-menu">
                                                    <span class="dropdown-header">Label as:</span>
                                                    <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                                </div>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
                                                                                    More
                                                                                    <span class="caret m-l-5"></span>
                                                                                </button>
                                                <div class="dropdown-menu">
                                                    <span class="dropdown-header">More Option :</span>
                                                    <a class="dropdown-item" href="javascript: void(0);">Mark as Unread</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Add to Tasks</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Add Star</a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Mute</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h5><?php echo $my_msg->subject; ?></h5>

                                            <hr/>

                                            <div class="media mb-4 mt-1">
                                                <div style="width: 32px; height: 32px; margin-right: 5px;">

                                                    <?php 
                                                    if($my_msg->profile != '') {
                                                        echo '<img style="height: 100%;" class="d-flex mr-3 rounded-circle" src="../backend/images/profile/'.$my_msg->profile.'">';
                                                        //echo '<img src=" '. $ich .' " >';
                                                    } else {
                                                        echo '<i style="font-size: 32px;" class="fa fa-user-circle-o"></i>';
                                                    } 
                                                    ?>

                                                </div>
                                                <div class="media-body">
                                                    <span class="pull-right"><?php echo $my_msg->date_time ?> AM</span>
                                                    <h6 class="m-0"><?php echo isset($_GET['read_sent']) ? 'to: ' : '' ?> <?php echo $my_msg->full_name; ?></h6>
                                                    <small class="text-muted">email: <?php echo $my_msg->email; ?></small>
                                                </div>
                                            </div>

                                            <div>
                                                <?php echo $my_msg->message; ?>
                                            </div>

                                            <hr/>

                                            <?php
	                                            if($my_msg->property_id != 0) {
	                                            	$msg_pro = Property::find_by_id($my_msg->property_id);
	                                            	if($msg_pro) {
	                                        ?>
	                                        			<div class="container-fluid">
                                                            <h6> <i class="fa fa-paperclip mb-2"></i> Attachments <span>(1)</span> </h6>

                                                            <div style="height: 120px" class="row bg-white">
                                                                <div class="col-md-3 p-l-0" style="overflow: hidden;">
                                                                    <img src='../backend/images/lister/<?php if($msg_pro->display != ''){echo $msg_pro->id.'/'.$msg_pro->display;}else{echo 'placeholder.png';}?>'>
                                                                </div>
                                                                <div class="col-md-6 p-t-10">
                                                                    <h4 class="m-b-4"><?php echo $msg_pro->address;?></h4>
                                                                    <p class="m-t-2"><i class="fa fa-map-marker m-r-5"></i><?php echo $msg_pro->state;?></p>
                                                                    <p><span class="m-r-15"><i class="fa fa-bed m-r-5"></i><?php echo $msg_pro->bed;?></span> <span class="m-r-15"><i class="fa fa-bath m-r-5"></i><?php echo $msg_pro->bath;?></span> <span class="m-r-15"><i class="fa fa-crop m-r-5"></i><?php echo $msg_pro->area;?></span> <span class="m-r-15"><i class="fa fa-tag m-r-5"></i>For Rent</span></p>
                                                                </div>
                                                                <div class="col-md-3 p-t-10">
                                                                    <?php 
                                                                        if($msg_pro->no_years > 0) {
                                                                            $monthly_price = $msg_pro->price / ($msg_pro->no_years * 12) ;
                                                                        }else {
                                                                            $monthly_price = 0;
                                                                        }
                                                                    ?> 
                                                                    <h3><?php echo number_format($msg_pro->price, 2, '.', ',');?></h3>
                                                                    <p><?php echo 'N'. number_format($monthly_price, 2, '.', ',') .' For '.$msg_pro->no_years;?> years</p>
                                                                </div>
                                                            </div>
                                                        </div>
	                                        <?php    		
	                                            	}
	                                            }
                                            ?>
                                            <!-- <h6> <i class="fa fa-paperclip mb-2"></i> Attachments <span>(3)</span> </h6>

                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <a href="#"> <img src="images/attached-files/img-1.jpg" alt="attachment" class="img-thumbnail img-responsive"> </a>
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="#"> <img src="images/attached-files/img-2.jpg" alt="attachment" class="img-thumbnail img-responsive"> </a>
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="#"> <img src="images/attached-files/img-3.jpg" alt="attachment" class="img-thumbnail img-responsive"> </a>
                                                </div>
                                            </div> -->
                                                
                                                <div class="form-group m-t-20">
                                                    <div class="text-right">
                                                        <a href="<?php echo $delete_link;?>" class="btn btn-success waves-effect waves-light m-r-5"><i class="fa fa-trash-o"></i></a>
                                                <?php
                                                if(!isset($_GET['read_sent'])) {
                                                ?>
                                                        <button type="submit" class="btn btn-purple waves-effect waves-light"> <span>Reply</span> <i class="fa fa-reply m-l-10"></i> </button>
                                                <?php
                                                }
                                                ?>        
                                                    </div>
                                                </div>
                                        </div>
                                        <!-- card-box -->

                                    </div>
                                </div>
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



        <!-- End Page wrapper  -->
<?php include("includes/footer.php"); ?>