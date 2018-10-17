<?php require_once('../../private/initialize.php'); 

require_login();


if(isset($_GET['sent_mail'])) {
    $sent_mail = $_GET['sent_mail'];
    $recieved_msgs = Message::get_person_msg('sender');

} else {
    $recieved_msgs = Message::get_person_msg('receiver');
    
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
                                        <a class="btn btn-danger btn-block waves-effect waves-light" href="message_compose.php">Compose</a>
                                        <div class="mail-list mt-4">
                                            <a class="list-group-item border-0 text-danger <?php echo (!isset($sent_mail)) ? 'actived':'' ; ?>" href="message_inbox.php"><i class="mdi mdi-inbox font-18 align-middle mr-2"></i><b>Inbox</b><span class="label inbx_cnt label-danger float-right ml-2"><?php echo $unrd_msg_cnt;?></span></a>
                                            <a class="list-group-item border-0" href="#"><i class="mdi mdi-file-document-box font-18 align-middle mr-2"></i>Draft<span class="label label-info float-right ml-2">0</span></a>
                                            <a class="list-group-item border-0 <?php echo (isset($sent_mail)) ? 'actived':'' ; ?>" href="?sent_mail=true"><i class="mdi mdi-send font-18 align-middle mr-2"></i>Sent Mail</a>
                                            <a class="list-group-item border-0" href="#"><i class="mdi mdi-delete font-18 align-middle mr-2"></i>Trash</a>
                                        </div>
                                    </div>
                                    <!-- End Left sidebar -->

                                    <div class="inbox-rightbar">

                                        <div role="toolbar" class="">
                                            <div class="btn-group">
                                                <button class="btn btn-light waves-effect" type="button"><i class="mdi mdi-archive font-18 vertical-middle"></i></button>
                                                <button class="btn btn-light waves-effect" type="button"><i class="mdi mdi-alert-octagon font-18 vertical-middle"></i></button>
                                                <button id="dltInbx" class="btn btn-light waves-effect" type="button"><i class="fa fa-trash-o"></i></button>
                                            </div>
                                            <div class="btn-group">
                                                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-light dropdown-toggle waves-effect" type="button">
                                                    More
                                                    <span class="caret m-l-5"></span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <span class="dropdown-header">More Option :</span>
                                                    <a href="javascript: void(0);" id="mrkUnRd" class="dropdown-item">Mark as Unread</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="">
                                            <div class="mt-4">
                                                <div class="">
                                                    <ul class="message-list">

                                                        <?php
                                                        if($recieved_msgs) {
                                                            foreach ($recieved_msgs as $recieved_msg) {
                                                                if(isset($_GET['sent_mail'])) {
                                                                    $read_stat = '&read_sent='.$recieved_msg->receiver_id;
                                                                } else {
                                                                    $read_stat = NULL;
                                                                }
                                                                // pr($recieved_msg);
                                                                if(!isset($_GET['sent_mail'])) {
                                                                    $person_dts = SystemUsers::find_by_id($recieved_msg->sender_id);
                                                                }else {
                                                                    $person_dts = SystemUsers::find_by_id($recieved_msg->receiver_id);
                                                                }
                                                            ?>

                                                            <li <?php if(!isset($sent_mail)) {echo ($recieved_msg->receiver_view == 0) ? 'class="unread"' : '';} ?>>
                                                                <a href="read_message.php?sprech=<?php echo $recieved_msg->id; ?><?php echo $read_stat; ?>&eup=rsano3/listing/gs_l=16d&bots=12_4tqy">
                                                                    <div class="col-mail col-mail-1">
                                                                        <div class="checkbox-wrapper-mail">
                                                                            <input type="checkbox" name="msgKiste[]" class="msgChkbx" value="<?php echo $recieved_msg->id; ?>" id="chk_<?php echo $recieved_msg->id; ?>">
                                                                            <label class="toggle kst_lbl" for="chk_<?php echo $recieved_msg->id; ?>"></label>
                                                                        </div>
                                                                        <p class="title">
                                                                            <?php
                                                                            echo (isset($_GET['sent_mail']))  ? '<small>To:</small> ' : '';
                                                                            echo $person_dts->full_name;
                                                                            ?>
                                                                        </p><span class="star-toggle fa fa-star-o"></span>
                                                                    </div>
                                                                    <div class="col-mail col-mail-2">
                                                                        <div class="subject"><?php echo $recieved_msg->subject; ?> &nbsp;&ndash;&nbsp;
                                                                            <span class="teaser"><?php echo $recieved_msg->message; ?></span>
                                                                        </div>
                                                                    <?php
                                                                    if($recieved_msg->property_id != 0) {
                                                                    ?>
                                                                        <div class="msg_ibx_atc">
                                                                            <span class="fa fa-paperclip"></span>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                        <div class="date">5:01 am</div>
                                                                    </div>

                                                                </a>
                                                            </li>

                                                            <?php
                                                            }  
                                                        } else {
                                                            echo '<li>You have no messages</li>';
                                                        }
                                                        ?>

                                                    </ul>
                                                </div>

                                            </div>
                                            <!-- panel body -->
                                        </div>
                                        <!-- panel -->

                                        <div class="row">
                                            <div class="col-7">
                                                Showing 1 - 20 of 2
                                            </div>
                                            <div class="col-5">
                                                <div class="btn-group float-right">
                                                    <button class="btn btn-gradient waves-effect" type="button"><i class="fa fa-chevron-left"></i></button>
                                                    <button class="btn btn-gradient waves-effect" type="button"><i class="fa fa-chevron-right"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

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
    <!-- End Wrapper -->

<?php include("includes/footer.php"); ?>